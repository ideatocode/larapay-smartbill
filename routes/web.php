<?php


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use AlexEftimie\LaravelPayments\Models\Invoice;

Route::middleware(['web'])->group(function () {

    Route::get('/invoice/{invoice}/download', function (Invoice $invoice) {
        if (!Gate::allows('download', $invoice)) {
            abort(403);
        }
        $meta = $invoice->getMetaValue('invoice::pdf');
        $filename = "invoice_" . $meta['series'] . '_' . $meta['number'] . '.pdf';
        return response(Storage::disk('local')->get($meta['path']))
            ->withHeaders([
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
    })->name('larapay-sb.download');
});
