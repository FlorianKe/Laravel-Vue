<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class OcrService
{
    /**
     * @throws Exception
     */
    public static function extractText(string $filePath): string
    {
        $response = Http::ocr()->timeout(60)
            ->attach('file', fopen($filePath, 'r'), 'receipt.jpg')
            ->post('parse/image', [
                'apikey' => config('services.ocr.api_key'),
                'language' => 'ger',
                'isTable' => 'true',
                'detectOrientation' => 'true',
            ]);

        if (($response->json('OCRExitCode') ?? 0) !== 1) {
            throw new Exception('OCR failed');
        }

        return $response->json('ParsedResults.0.ParsedText', '');
    }
}
