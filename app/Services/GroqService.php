<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
    }

    public function generateCoverLetter(array $biodata, array $job): string
    {
        $prompt = $this->buildPrompt($biodata, $job);

        $response = Http::withToken($this->apiKey)
            ->timeout(30)
            ->post($this->baseUrl, [
                'model'       => $this->model,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten profesional yang ahli dalam menulis surat lamaran kerja dalam Bahasa Indonesia yang formal, menarik, dan personal. Tulis surat yang langsung to-the-point tanpa basa-basi berlebihan.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens'  => 1024,
            ]);

        if ($response->failed()) {
            Log::error('Groq API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Gagal menghubungi Groq API. Coba lagi nanti.');
        }

        $data = $response->json();

        return $data['choices'][0]['message']['content'] ?? 'Gagal menghasilkan surat lamaran.';
    }

    protected function buildPrompt(array $biodata, array $job): string
    {
        return <<<PROMPT
Buatkan surat lamaran kerja profesional dalam Bahasa Indonesia berdasarkan informasi berikut:

== DATA PELAMAR ==
Nama          : {$biodata['name']}
Email         : {$biodata['email']}
Nomor HP      : {$biodata['phone']}
Keahlian/Skill: {$biodata['skills']}
Pengalaman    : {$biodata['experience']}

== DATA LOWONGAN ==
Posisi yang Dilamar : {$job['title']}
Perusahaan          : {$job['company']}
Lokasi              : {$job['location']}
Tipe Pekerjaan      : {$job['type']}
Deskripsi Pekerjaan : {$job['description']}

== INSTRUKSI ==
- Tulis surat lamaran yang formal dan profesional
- Sesuaikan keahlian pelamar dengan kebutuhan posisi
- Gunakan bahasa yang sopan namun tidak terlalu kaku
- Format: Pembukaan → Paragraf pengenalan diri → Paragraf keahlian/pengalaman → Penutup
- Sertakan salam pembuka dan penutup yang tepat
- Jangan tambahkan placeholder seperti [Nama] atau [Tanggal], langsung isi dengan data yang tersedia
PROMPT;
    }
}