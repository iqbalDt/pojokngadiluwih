<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatbotController extends Controller
{
    /**
     * Bridge API requests to the Python FastAPI AI service.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $message = trim((string) $request->input('message', ''));

        if ($message === '') {
            return response()->json([
                'status' => 'error',
                'reply' => 'Mohon ketikkan pertanyaan atau informasi yang ingin Anda tanyakan.',
                'source_context' => [],
            ], 422);
        }

        $pythonServiceUrl = (string) config('services.ai_service.url', 'http://127.0.0.1:8001/api/chat');
        $timeout = (int) config('services.ai_service.timeout', 120);

        try {
            @ini_set('max_execution_time', (string) ($timeout + 30));
            set_time_limit($timeout + 30);
            $response = Http::timeout($timeout)->post($pythonServiceUrl, [
                'message' => $message,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return response()->json([
                    'status' => 'success',
                    'reply' => $data['reply'] ?? 'Tidak ada jawaban yang dihasilkan.',
                    'source_context' => $data['source_context'] ?? [],
                ]);
            }

            Log::warning('AI Service returned non-success response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (Throwable $e) {
            // Service AI Python belum aktif atau sedang inisialisasi
            Log::error('AI Service connection failed', [
                'url' => $pythonServiceUrl,
                'error' => $e->getMessage(),
            ]);
        }

        // Respon cadangan jika service AI mengalami kendala koneksi
        return response()->json([
            'status' => 'fallback',
            'reply' => "Mohon maaf, koneksi ke asisten AI sedang dipulihkan atau mengalami jeda sesaat. Silakan coba kirim ulang pertanyaan Anda: \"{$message}\" dalam beberapa detik lagi ya!",
            'source_context' => [],
        ]);
    }
}
