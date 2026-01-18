<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiParserServices
{
    /**
     * @return array{merchant: string, date: string, total: float, currency: string, vat: string}
     */
    public function parseReceipt(string $ocrText): array
    {
        $response = Http::perplexity()
            ->post('chat/completions', [
                'model' => 'sonar',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Your are a helpful assistant that can extract data from receipts.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($ocrText),
                    ],
                ],
                'temperature' => 0.2,
            ]);

        return json_decode($response->json('choices.0.message.content'), true);
    }

    private function buildPrompt(string $ocrText): string
    {
        return <<<PROMPT
        Analyse the following receipt text and extract the data as JSON:

        Scanned text:
        $ocrText

        Answer with JSON with these fields:
        {
          "merchant": "Handelsname",
          "date": "DD.MM.YYYY",
          "total": 0.00,
          "currency": "EUR",
          "vat": "19"
        }

        IMPORTANT: Answer ONLY with the JSON, no Markdown, no explanation!
        PROMPT;
    }
}
