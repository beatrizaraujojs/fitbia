<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class PasswordRecoveryController extends Controller
{
    private function encontrarCliente(string $email)
    {
        return Cliente::where('email_cliente', $email)->first();
    }

    public function solicitar(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
        ]);

        $email = Str::lower(trim($dados['email']));
        $chave = 'recuperacao:' . hash('sha256', $email);

        if (RateLimiter::tooManyAttempts($chave, 3)) {
            return response()->json([
                'message' => 'Aguarde antes de solicitar outro código.'
            ], 429);
        }

        RateLimiter::hit($chave, 300);

        $cliente = $this->encontrarCliente($email);

        // Resposta genérica para não revelar quais e-mails existem.
        $mensagem = [
            'message' => 'Caso o e-mail esteja cadastrado, você receberá um código.'
        ];

        if (!$cliente || $cliente->status_cliente !== 'ATIVO') {
            return response()->json($mensagem);
        }

        $codigo = (string) random_int(1000, 9999);

        try {
            Mail::raw(
                "Seu código de recuperação FitBia é: {$codigo}\n\n" .
                "Ele expira em 2 minutos. Não compartilhe este código.",
                function ($mail) use ($email) {
                    $mail->to($email)
                         ->subject('FitBia - Código de recuperação');
                }
            );
        } catch (\Throwable $erro) {
            Log::error('Falha no envio de recuperação', [
                'error' => $erro->getMessage()
            ]);

            return response()->json([
                'message' => 'Não foi possível enviar o código agora.'
            ], 503);
        }

        DB::transaction(function () use ($cliente, $codigo) {
            DB::table('password_reset_codes')
                ->where('id_cliente', $cliente->id_cliente)
                ->delete();

            DB::table('password_reset_codes')->insert([
                'id_cliente' => $cliente->id_cliente,
                'code_hash' => Hash::make($codigo),
                'expires_at' => now()->addMinutes(2),
                'attempts' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return response()->json($mensagem);
    }

    public function validar(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'codigo' => ['required', 'regex:/^[0-9]{4}$/'],
        ]);

        $cliente = $this->encontrarCliente(
            Str::lower(trim($dados['email']))
        );

        if (!$cliente) {
            return response()->json([
                'message' => 'Código inválido ou expirado.'
            ], 422);
        }

        $registro = DB::table('password_reset_codes')
            ->where('id_cliente', $cliente->id_cliente)
            ->first();

        if (
            !$registro ||
            $registro->verified_at ||
            now()->greaterThan($registro->expires_at) ||
            $registro->attempts >= 5
        ) {
            return response()->json([
                'message' => 'Código inválido ou expirado.'
            ], 422);
        }

        if (!Hash::check($dados['codigo'], $registro->code_hash)) {
            DB::table('password_reset_codes')
                ->where('id', $registro->id)
                ->increment('attempts');

            return response()->json([
                'message' => 'Código inválido.'
            ], 422);
        }

        $resetToken = Str::random(64);

        DB::table('password_reset_codes')
            ->where('id', $registro->id)
            ->update([
                'verified_at' => now(),
                'reset_token_hash' => hash('sha256', $resetToken),
                'reset_expires_at' => now()->addMinutes(5),
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Código validado com sucesso.',
            'reset_token' => $resetToken,
        ]);
    }

    public function redefinir(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'reset_token' => 'required|string',
            'senha' => 'required|string|min:8|confirmed',
        ]);

        $cliente = $this->encontrarCliente(
            Str::lower(trim($dados['email']))
        );

        if (!$cliente) {
            return response()->json([
                'message' => 'Autorização inválida ou expirada.'
            ], 422);
        }

        $registro = DB::table('password_reset_codes')
            ->where('id_cliente', $cliente->id_cliente)
            ->first();

        if (
            !$registro ||
            !$registro->verified_at ||
            !$registro->reset_token_hash ||
            now()->greaterThan($registro->reset_expires_at) ||
            !hash_equals(
                $registro->reset_token_hash,
                hash('sha256', $dados['reset_token'])
            )
        ) {
            return response()->json([
                'message' => 'Autorização inválida ou expirada.'
            ], 422);
        }

        DB::transaction(function () use ($cliente, $dados) {
            $cliente->senha_cliente = Hash::make($dados['senha']);
            $cliente->save();

            DB::table('password_reset_codes')
                ->where('id_cliente', $cliente->id_cliente)
                ->delete();
        });

        return response()->json([
            'message' => 'Senha redefinida com sucesso.'
        ]);
    }
}
