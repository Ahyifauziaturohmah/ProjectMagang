<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappHelper
{
    /**
     * Fungsi kirim pesan WA via Fonnte
     *
     * @param string $target (Nomor HP tujuan)
     * @param string $message (Isi pesan)
     * @return array
     */
    public static function send($target, $message)
    {
        // LOGIC PENYESUAIAN NOMOR:
        // Hapus karakter non-angka (seperti spasi atau strip)
        $target = preg_replace('/[^0-9]/', '', $target);

        // Jika nomor diawali '08', ubah jadi '628'
        if (strpos($target, '0') === 0) {
            $target = '62' . substr($target, 1);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ]);

            Log::info("Fonnte Sent to {$target}: " . $response->body());
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());
            return ['status' => false, 'reason' => 'Server Error'];
        }
    }
}