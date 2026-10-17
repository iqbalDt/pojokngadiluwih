<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

        $pythonServiceUrl = (string) env('AI_SERVICE_URL', 'http://127.0.0.1:8001/api/chat');

        try {
            set_time_limit(45);
            $response = Http::timeout(20)->post($pythonServiceUrl, [
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
        } catch (Throwable) {
            // Service AI Python belum aktif atau sedang inisialisasi
        }

        // Fallback cerdas jika service Python sedang offline atau dalam proses inisialisasi
        return response()->json([
            'status' => 'success',
            'reply' => "Halo! Saya Asisten Virtual Desa Ngadiluwih. Pertanyaan Anda: \"{$message}\" telah kami terima.\n\nDi portal PojokNgadiluwih ini, Anda dapat menanyakan berbagai informasi resmi seputar:\n1. Panduan & syarat surat desa (SKU, SKCK, Surat Domisili, SKTM)\n2. Rekomendasi produk UMKM warga & kontak WhatsApp pemesanan langsung\n3. Jam operasional loket balai desa (Senin-Jumat, 08.00 - 15.00 WIB)\n4. Profil aparatur desa, visi misi, dan wilayah 4 dusun.\n\nSilakan ketik pertanyaan Anda sesuai topik di atas atau hubungi WhatsApp balai desa di 0812-3456-7890.",
            'source_context' => ['PojokNgadiluwih Guidance Fallback'],
        ]);
    }
}
