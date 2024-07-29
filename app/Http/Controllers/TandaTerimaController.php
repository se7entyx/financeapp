<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\TandaTerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TandaTerimaController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();

        // dd($userId);

        // Validate Tanda Terima data
        $validated = $request->validate([
            'tanggal' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'faktur' => 'nullable|string',
            'po' => 'nullable|string',
            'bpb' => 'nullable|string',
            'sjalan' => 'nullable|string',
            'jatuh_tempo' => 'required|string',
            'notes' => 'nullable|string',
            'invoice' => 'required|array',
            'invoice.*' => 'required|string',
            'nominal' => 'required|array',
            'nominal.*' => 'required|numeric',
            'currency' => 'required|array',
            'currency.*' => 'required|string|in:IDR,USD',
        ]);

        // dd($validated);

        // Create Tanda Terima record
        $tandaTerima = new TandaTerima();
        $tandaTerima->user_id = $userId;
        $tandaTerima->tanggal = $validated['tanggal'];
        $tandaTerima->supplier_id = $validated['supplier_id'];
        $tandaTerima->pajak = $validated['faktur'];
        $tandaTerima->po = $validated['po'];
        $tandaTerima->bpb = $validated['bpb'];
        $tandaTerima->surat_jalan = $validated['sjalan'];
        $tandaTerima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
        $tandaTerima->keterangan = $validated['notes'];
        $tandaTerima->save();


        // Create Invoices records
        foreach ($validated['invoice'] as $index => $invoiceNo) {
            $invoice = new Invoices();
            $invoice->tanda_terima_id = $tandaTerima->id;
            $invoice->nomor = $validated['invoice'][$index];
            $invoice->nominal = $validated['nominal'][$index];
            $invoice->currency = $validated['currency'][$index];
            $invoice->save();
        }

        return redirect()->route('new.tanda-terima')->with('success', 'Tanda Terima created successfully.');
    }
    public function showAll()
    {
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->get();

        return view('alldoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => 'All Documents']);
    }

    public function getInvoices($tandaTerimaId)
    {
        // Fetch all invoices related to the specified tanda_terima_id
        $invoices = Invoices::where('tanda_terima_id', $tandaTerimaId)->get();

        // Return or process the results as needed
        return response()->json($invoices);
    }
}
