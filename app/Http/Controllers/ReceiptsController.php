<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptsRequest;
use App\Models\Receipts;
use App\Services\AiParserServices;
use App\Services\OcrService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ReceiptsController extends Controller
{
    public function index(): Response
    {
        $receipts = Receipts::all();

        return Inertia::render('receipts/index', [
            'receipts' => $receipts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Exception
     */
    public function store(StoreReceiptsRequest $request, AiParserServices $aiParserServices): RedirectResponse
    {
        try {
            $ocrText = OcrService::extractText($request->file('receipt')->getPathname());

            $receipt = $aiParserServices->parseReceipt($ocrText);

            Receipts::query()->create([
                'user_id' => user()->id,
                ...$receipt,
            ]);
        } catch (\Throwable) {
            throw ValidationException::withMessages([
                'receipt' => 'Scan failed. Please try later again.',
            ]);
        }

        // TODO: store receipt image in storage

        return back();
    }
}
