<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappHelper
{
    public static function send($target, $message)
    {
        // 1. Bersihkan nomor
        $target = preg_replace('/[^0-9]/', '', $target);

        // 2. Ubah 08 jadi 628
        if (strpos($target, '0') === 0) {
            $target = '62' . substr($target, 1);
        }

        try {
            // 3. Ganti env() jadi config() agar lebih stabil di Railway
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => config('services.fonnte.token', env('FONNTE_TOKEN')),
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