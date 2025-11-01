<?php

namespace App\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeminiService {
    protected Client $http;
    protected string $apiKey;
    protected string $endpoint;

    public function __construct() {
        $this->http = new Client();
        $this->apiKey = config('services.gemini.api_key');
        $this->endpoint = config('services.gemini.endpoint');
    }

    public function generateText(string $prompt) {
        // Build URL with API key as query parameter
        $url = $this->endpoint . '?key=' . $this->apiKey;
        
        // Gemini API expects a different JSON structure
        $response = $this->http->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.5,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 2048,
                ]
            ],
        ]);
        
        $body = json_decode($response->getBody()->getContents(), true);
        
        // Extract the text from the response
        if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
            return $body['candidates'][0]['content']['parts'][0]['text'];
        }
        
        // Log error for debugging
        Log::error('Gemini API response error', ['response' => $body]);
        throw new \RuntimeException('Resposta inválida da API do Gemini: ' . json_encode($body));
    }
}
