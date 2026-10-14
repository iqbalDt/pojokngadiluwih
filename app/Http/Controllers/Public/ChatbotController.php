<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Bridge API requests to the Python AI service.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $message = (string) $request->input('message', '');

        // Simulated intelligent bridge response (to be connected to Python AI service)
        return response()->json([
            'status' => 'success',
            'reply' => 'Halo! Saya asisten virtual PojokNgadiluwih. Terkait pertanyaan Anda: "'.$message.'", sistem kami sedang menghubungkannya ke model AI desa.',
        ]);
    }
}
