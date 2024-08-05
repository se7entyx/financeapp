<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Supplier;
use App\Models\TandaTerima;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TandaTerimaController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();

        // Validate Tanda Terima data
        $validated = $request->validate([
            'tanggal' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'faktur' => 'nullable|string',
            'po' => 'nullable|string',
            'bpb' => 'nullable|string',
            'sjalan' => 'nullable|string',
            'jatuh_tempo' => 'required|string',
            'currency' => 'required|string|in:IDR,USD',
            'notes' => 'nullable|string',
            'invoice' => 'required|array',
            'invoice.*' => 'required|string',
            'nominal' => 'required|array',
            'nominal.*' => 'required|numeric',
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
        $tandaTerima->currency = $validated['currency'];
        $tandaTerima->keterangan = $validated['notes'];
        $tandaTerima->save();


        // Create Invoices records
        foreach ($validated['invoice'] as $index => $invoiceNo) {
            $invoice = new Invoices();
            $invoice->tanda_terima_id = $tandaTerima->id;
            $invoice->nomor = $validated['invoice'][$index];
            $invoice->nominal = $validated['nominal'][$index];
            // $invoice->currency = $validated['currency'][$index];
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

    public function deleteTt($id)
    {
        $x = TandaTerima::find($id);
        $x->delete();

        return response()->with('success', 'Tanda terima deleted successfully!');
    }

    public function showEditForm($id)
    {
        $tandaTerima = TandaTerima::with('invoices')->findOrFail($id);
        $z = Supplier::all();
        $title = 'Edit Tanda Terima';

        // dd($tandaTerima->invoices);
        return view('editdoc', ['tandaTerimaRecords' => $tandaTerima, 'title' => $title, 'suppliers' => $z]);
    }

    public function update(Request $request, $id)
    {
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

        $tandaTerima = TandaTerima::findOrFail($id);
        $tandaTerima->supplier_id = $validated['supplier_id'];
        $tandaTerima->pajak = $validated['faktur'];
        $tandaTerima->po = $validated['po'];
        $tandaTerima->bpb = $validated['bpb'];
        $tandaTerima->surat_jalan = $validated['sjalan'];
        $tandaTerima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
        $tandaTerima->keterangan = $validated['notes'];
        $tandaTerima->save();

        $tandaTerima->invoices()->whereNotIn('nomor', $validated['invoice'])->delete();

        // Update or create invoices
        foreach ($validated['invoice'] as $index => $invoiceNo) {
            $invoice = $tandaTerima->invoices()->firstOrNew(['nomor' => $invoiceNo]);
            $invoice->nominal = $validated['nominal'][$index];
            $invoice->currency = $validated['currency'][$index];
            $invoice->save();
        }

        return redirect()->route('my.tanda-terima')->with('success', 'Tanda Terima created successfully.');
    }

    // public function showPrintTemplate($id)
    // {
    //     $tandaTerimaRecords = TandaTerima::with(['supplier', 'invoices'])->find($id);

    //     return view('print', ['tandaTerimaRecords' => $tandaTerimaRecords]);
    // }

    public function printTandaTerima($id)
    {
        $tandaTerima = TandaTerima::with(['supplier', 'invoices'])->find($id);

        $html = view('print', compact('tandaTerima'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $filePath = storage_path('app/public/tanda_terima.pdf');
        file_put_contents($filePath, $output);

        $fileUrl = asset('storage/tanda_terima.pdf');


        return redirect($fileUrl);
    }
}
