<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Importante para compartilhar com as views
use App\Models\Categoria; // Importa o seu Model

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compartilha as categorias ATIVAS com TODAS as páginas (Header) automaticamente
        try {
            $categoriasGlobais = Categoria::where('ativa_categoria', 'ATIVO')
                ->orderBy('nome_categoria')
                ->get();
                
            View::share('categorias', $categoriasGlobais);
        } catch (\Exception $e) {
            // Esse try/catch evita erros caso você vá rodar o sistema do zero em outro PC e a tabela ainda não exista
        }
    }
}