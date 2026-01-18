<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptsRequest;
use App\Models\Receipts;
use App\Models\User;
use App\Services\AiParserServices;
use App\Services\OcrService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ReceiptsController extends Controller
{
    public function index(): Response
    {
        $receipts = Receipts::all();

        return Inertia::render('Dashboard', [
            'receipts' => $receipts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws ConnectionException
     * @throws \Exception
     */
    public function store(#[CurrentUser] User $user, StoreReceiptsRequest $request, AiParserServices $aiParserServices): RedirectResponse
    {
        try {
            $ocrText = OcrService::extractText($request->file('receipt')->getPathname());

            $receipt = $aiParserServices->parseReceipt($ocrText);

            Receipts::query()->create([
                'user_id' => $user->id,
                ...$receipt,
            ]);
        } catch (\Throwable) {
            throw ValidationException::withMessages([
                'receipt' => 'OCR failed. Please try later again.',
            ]);
        }

        // TODO: store receipt image in storage

        return back();
    }
}
