<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API FitBia a funcionar perfeitamente!',
            'timestamp' => now()
        ]);
    }
}