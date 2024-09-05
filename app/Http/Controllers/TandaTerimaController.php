<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Supplier;
use App\Models\TandaTerima;
use App\Models\Tax;
use App\Models\Transaction;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TandaTerimaController extends Controller
{
    public function getTandaTerima()
    {
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user', 'bukti_kas'])->filter(request(['search', 'supplier', 'start_date', 'end_date', 'jatuh_tempo']))->sortable()->latest()->paginate(20)->withQueryString();

        $title = 'All Document';
        return view('alldoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title]);
    }

    public function getMyTandaTerima()
    {
        $id = Auth::id();
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user', 'bukti_kas'])->where('user_id', $id)->filter(request(['search', 'supplier', 'start_date', 'end_date', 'jatuh_tempo']))->sortable()->latest()->paginate(20)->withQueryString();
        $title = 'My Tanda Terima';
        return view('mydoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title]);
    }
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error retrieving user ID: ' . $e->getMessage()]);
        }

        try {
            // Validate Tanda Terima data
            $validated = $request->validate([
                'tanggal' => 'required|string',
                'supplier_id' => 'required|exists:suppliers,id',
                'faktur' => 'nullable|string',
                'po' => 'nullable|string',
                'bpb' => 'nullable|string',
                'sjalan' => 'nullable|string',
                'jatuh_tempo' => 'required|string',
                'currency' => 'required|string|in:Rp,USD',
                'notes' => 'nullable|string',
                'invoice' => 'required|array',
                'invoice.*' => 'required|string',
                'nominal' => 'required|array',
                'nominal.*' => 'required|numeric',
                'trans_count' => 'required|array',
                'trans_count.*' => 'required|string',
                'keterangan' => 'required|array',
                'keterangan.*' => 'required|string',
                'trans_nominal' => 'required|array',
                'trans_nominal.*' => 'required|numeric',
                'po_number' => 'nullable|string'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Validation error: ' . $e->getMessage()]);
        }

        try {
            // Create Tanda Terima record
            $tandaTerima = new TandaTerima();
            $tandaTerima->user_id = $userId;
            $tandaTerima->tanggal = $validated['tanggal'];
            $tandaTerima->supplier_id = $validated['supplier_id'];
            $tandaTerima->pajak = $validated['faktur'];
            $tandaTerima->po = $validated['po'];
            $tandaTerima->bpb = $validated['bpb'];
            $tandaTerima->surat_jalan = $validated['sjalan'];
            $tandaTerima->nomor_po = $validated['po_number'];
            $tandaTerima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
            $tandaTerima->currency = $validated['currency'];
            $tandaTerima->keterangan = $validated['notes'];
            $tandaTerima->save();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error saving Tanda Terima: ' . $e->getMessage()]);
        }

        try {
            // Initialize a variable to track the transaction index
            $transIndex = 0;

            // Create Invoices records
            foreach ($validated['invoice'] as $index => $invoiceNo) {
                $invoice = new Invoices();
                $invoice->tanda_terima_id = $tandaTerima->id;
                $invoice->nomor = $validated['invoice'][$index];
                $invoice->nominal = $validated['nominal'][$index];
                $invoice->save();

                // Get the number of transactions for this invoice
                $transCount = $validated['trans_count'][$index];
                $transCount = intval($transCount);

                // Create Transaction records for this invoice
                for ($i = 1; $i <= $transCount; $i++) {
                    try {
                        $trans = new Transaction();
                        $trans->invoice_id = $invoice->id;
                        $trans->keterangan = $validated['keterangan'][$transIndex];
                        $trans->nominal = $validated['trans_nominal'][$transIndex];
                        $trans->save();
                    } catch (\Exception $e) {
                        return back()->withErrors(['error' => 'Error saving transaction: ' . $e->getMessage()]);
                    }

                    // Increment the transaction index
                    $transIndex++;
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error saving invoices and transactions: ' . $e->getMessage()]);
        }

        return redirect()->route('new.tanda-terima')->with('success', 'Tanda Terima created successfully.');
    }

    public function getInvoices($tandaTerimaId)
    {
        // Fetch the currency value from the related TandaTerima model
        $tandaTerima = TandaTerima::find($tandaTerimaId);
        $invoiceData = [];

        foreach ($tandaTerima->invoices as $invoice) {
            foreach ($invoice->transaction as $transaction) {
                $taxPpn = Tax::where('id', $transaction->id_ppn)->first();
                $taxPph = Tax::where('id', $transaction->id_pph)->first();

                $invoiceData[] = [
                    'invoice_id' => $invoice->id,
                    'invoice_keterangan' => $invoice->nomor,
                    'invoice_nominal' => $invoice->nominal,
                    'transaction_id' => $transaction->id,
                    'transaction_keterangan' => $transaction->keterangan,
                    'transaction_nominal' => $transaction->nominal,
                    'nominal_setelah' => $transaction->nominal_setelah,
                    'nominal_ppn' => $transaction->nominal_ppn,
                    'nominal_pph' => $transaction->nominal_pph,
                    'name_ppn' => $taxPpn ? $taxPpn->name : null,
                    'name_pph' => $taxPph ? $taxPph->name : null,
                    'currency' => $tandaTerima->currency,
                ];
            }
        }

        // Return the combined response as JSON
        return response()->json($invoiceData);
    }

    public function getInvoicesDetail($tandaTerimaId)
    {
        $tandaTerima = TandaTerima::find($tandaTerimaId);
        $invoiceData = [];
        foreach ($tandaTerima->invoices as $invoice) {
            $invoiceData[] = [
                'invoice_keterangan' => $invoice->nomor,
                'invoice_nominal' => $invoice->nominal,
                'currency' => $tandaTerima->currency,
            ];
        }

        return response()->json($invoiceData);
    }


    public function deleteTt($id)
    {
        $x = TandaTerima::find($id);
        $x->delete();

        return back()->with('success', 'Action completed successfully!');
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
            'currency' => 'required|string|in:Rp,USD',
            'notes' => 'nullable|string',
            'invoice' => 'required|array',
            'invoice.*' => 'required|string',
            'nominal' => 'required|array',
            'nominal.*' => 'required|numeric',
            'trans_count' => 'required|array',
            'trans_count.*' => 'required|string',
            'keterangan' => 'required|array',
            'keterangan.*' => 'required|string',
            'trans_nominal' => 'required|array',
            'trans_nominal.*' => 'required|numeric',
        ]);

        // Update Tanda Terima record
        $tandaTerima = TandaTerima::findOrFail($id);
        $tandaTerima->supplier_id = $validated['supplier_id'];
        $tandaTerima->pajak = $validated['faktur'];
        $tandaTerima->po = $validated['po'];
        $tandaTerima->bpb = $validated['bpb'];
        $tandaTerima->currency = $validated['currency'];
        $tandaTerima->surat_jalan = $validated['sjalan'];
        $tandaTerima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
        $tandaTerima->keterangan = $validated['notes'];
        $tandaTerima->save();

        // Delete invoices and transactions not in the request
        $tandaTerima->invoices()->whereNotIn('nomor', $validated['invoice'])->delete();

        // Initialize a variable to track the transaction index
        $transIndex = 0;
        $total = 0.0;

        // Update or create invoices and transactions
        foreach ($validated['invoice'] as $index => $invoiceNo) {
            $invoice = $tandaTerima->invoices()->updateOrCreate(
                ['nomor' => $invoiceNo],
                ['nominal' => $validated['nominal'][$index]]
            );

            // Get the number of transactions for this invoice
            $transCount = intval($validated['trans_count'][$index]);

            // Remove any transactions not included in the request for this invoice
            $invoice->transaction()->whereNotIn('keterangan', array_slice($validated['keterangan'], $transIndex, $transCount))->delete();

            // Update or create transactions for this invoice
            for ($i = 0; $i < $transCount; $i++) {
                $transaction = $invoice->transaction()->updateOrCreate(
                    ['keterangan' => $validated['keterangan'][$transIndex]],
                    ['nominal' => $validated['trans_nominal'][$transIndex]]
                );

                // Add the transaction nominal to the total
                $total += $transaction->nominal;

                // Handle PPN and PPH calculations
                $ppnAmount = 0;
                $pphAmount = 0;

                if ($transaction->id_ppn) {
                    $ppn = Tax::find($transaction->id_ppn);
                    if ($ppn && $ppn->type == 'ppn') {
                        $ppnAmount = ($transaction->nominal * $ppn->percentage) / 100;
                    }
                }

                if ($transaction->id_pph) {
                    $pph = Tax::find($transaction->id_pph);
                    if ($pph && $pph->type == 'pph') {
                        $pphAmount = ($transaction->nominal * $pph->percentage) / 100;
                    }
                }

                // Add PPN and subtract PPH from the total
                $ppnAmount = round($ppnAmount);
                $pphAmount = round($pphAmount);
                $total = $total + $ppnAmount - $pphAmount;

                // Update the transaction with PPN and PPH amounts
                $transaction->nominal_ppn = $ppnAmount;
                $transaction->nominal_pph = $pphAmount;
                $transaction->save();

                // Update the associated Bukti Kas if applicable
                if ($tandaTerima->bukti_kas) {
                    $tandaTerima->bukti_kas->jumlah = $total;
                    $tandaTerima->bukti_kas->save();
                }

                // Increment the transaction index
                $transIndex++;
            }
        }

        return redirect()->route('my.tanda-terima')->with('success', 'Tanda Terima updated successfully.');
    }


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
