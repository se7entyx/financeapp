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
                'po_number' => 'nullable|string',
                'satuan' => 'required|array',
                'satuan.*' => 'nullable|string',
                'quantity' => 'required|array',
                'quantity.*' => 'nullable|numeric',
                'harga_satuan' => 'required|array',
                'harga_satuan.*' => 'nullable|numeric'
            ]);

            // dd($validated['quantity']);
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
                        $trans->quantity = $validated['quantity'][$transIndex];
                        $trans->harga_satuan = $validated['harga_satuan'][$transIndex];
                        $trans->satuan = $validated['satuan'][$transIndex];
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

    public function showEditForm($id, $from)
    {
        $tandaTerima = TandaTerima::with(['invoices', 'bukti_kas'])->findOrFail($id);

        if ($tandaTerima->bukti_kas !== null) {
            if ($tandaTerima->bukti_kas->status == 'Sudah dibayar') {
                abort(403, 'Access denied.');
            }
        }

        if ($from != 'my' && $from != 'all') {
            abort(403, 'Wrong URL.');
        }

        if (Auth::user()->role == 'user' && $tandaTerima->user_id != Auth::id()) {
            return redirect()->route('my.tanda-terima')->with('false', 'error encounter');
        }

        if (Auth::user()->role == 'user' && $from == 'all') {
            return redirect()->route('my.tanda-terima')->with('false', 'error encounter');
        }

        if (Auth::user()->role != 'user' && $from == 'my' && $tandaTerima->user_id != Auth::id()) {
            return redirect()->route('all.tanda-terima')->with('false', 'error encounter');
        }

        $usedPONumbers = TandaTerima::pluck('nomor_po')->toArray();
        $usedInvoiceNumbers = Invoices::pluck('nomor')->toArray();

        $z = Supplier::orderBy('name', 'asc')->get();
        $title = 'Edit Tanda Terima';
        // dd($tandaTerima);

        // dd($tandaTerima->invoices);
        return view('editdoc', ['tandaTerimaRecords' => $tandaTerima, 'usedPONumbers' => $usedPONumbers, 'title' => $title, 'suppliers' => $z, 'from' => $from, 'usedInvoiceNumbers' => $usedInvoiceNumbers]);
    }

    public function update(Request $request, $id, $from)
    {
        // Validate Tanda Terima data
        $validated = $request->validate([
            'tanggal' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'faktur' => 'nullable|string',
            'po' => 'nullable|string',
            'bpb' => 'nullable|string',
            'sjalan' => 'nullable|string',
            'po_number' => 'nullable|string',
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
            'satuan' => 'nullable|array',
            'satuan.*' => 'nullable|string',
            'quantity' => 'nullable|array',
            'quantity.*' => 'nullable|numeric',
            'harga_satuan' => 'nullable|array',
            'harga_satuan.*' => 'nullable|numeric',
            'trans_id' => 'nullable|array',
            'trans_id.*' => 'nullable|string',
        ]);
    
        // Update Tanda Terima record
        $tandaTerima = TandaTerima::findOrFail($id);
        $tandaTerima->supplier_id = $validated['supplier_id'];
        $tandaTerima->pajak = $validated['faktur'];
        $tandaTerima->bpb = $validated['bpb'];
        $tandaTerima->currency = $validated['currency'];
        $tandaTerima->surat_jalan = $validated['sjalan'];
        $tandaTerima->po = $tandaTerima->po === 'true' ? 'true' : $validated['po'];
        $tandaTerima->nomor_po = $validated['po_number'];
        $tandaTerima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
        $tandaTerima->keterangan = $validated['notes'];
        $tandaTerima->save();
    
        // Delete invoices not present in the request
        $tandaTerima->invoices()->whereNotIn('nomor', $validated['invoice'])->delete();
    
        // Initialize variables
        $transIndex = 0;
        $total = 0.0;
    
        foreach ($validated['invoice'] as $index => $invoiceNo) {
            // Update or create invoice
            $invoice = $tandaTerima->invoices()->updateOrCreate(
                ['nomor' => $invoiceNo],
                ['nominal' => $validated['nominal'][$index]]
            );
    
            // Clear previous transactions for the invoice
            $temp = $invoice->transaction()->get();
            $invoice->transaction()->delete();
    
            $transCount = intval($validated['trans_count'][$index]);
    
            for ($i = 0; $i < $transCount; $i++) {
                // Create a new transaction
                $transaction = $invoice->transaction()->create([
                    'keterangan' => $validated['keterangan'][$transIndex],
                    'nominal' => $validated['trans_nominal'][$transIndex],
                    'quantity' => $validated['quantity'][$transIndex],
                    'satuan' => $validated['satuan'][$transIndex],
                    'harga_satuan' => $validated['harga_satuan'][$transIndex],
                ]);
    
                $total += $transaction->nominal;
    
                // Initialize tax amounts
                $ppnAmount = 0;
                $pphAmount = 0;
    
                // Handle tax assignment
                if (!empty($validated['trans_id'][$transIndex])) {
                    $existingTransaction = $temp->firstWhere('id', $validated['trans_id'][$transIndex]);
    
                    if ($existingTransaction) {
                        // Handle PPN tax
                        if ($existingTransaction->id_ppn) {
                            $id_ppn = $existingTransaction->id_ppn;
                            $transaction->id_ppn = $id_ppn;
                            $ppn = Tax::find($id_ppn);
                            if ($ppn && $ppn->type == 'ppn') {
                                $ppnAmount = ($transaction->nominal * $ppn->percentage) / 100;
                                $ppnAmount = round($ppnAmount);
                                $transaction->nominal_ppn = $ppnAmount;
                            }
                        }
    
                        // Handle PPH tax
                        if ($existingTransaction->id_pph) {
                            $id_pph = $existingTransaction->id_pph;
                            $transaction->id_pph = $id_pph;
                            $pph = Tax::find($id_pph);
                            if ($pph && $pph->type == 'pph') {
                                $pphAmount = -($transaction->nominal * $pph->percentage) / 100;
                                $pphAmount = round($pphAmount);
                                $transaction->nominal_pph = $pphAmount;
                            }
                        }
                    }
                }
    
                // Update total with taxes
                $total += $ppnAmount + $pphAmount;
                $transaction->save();
    
                $transIndex++;
            }
    
            // Update the related bukti_kas with the total
            if ($tandaTerima->bukti_kas) {
                $tandaTerima->bukti_kas->jumlah = $total;
                $tandaTerima->bukti_kas->save();
            }
        }
    
        // Redirect based on the `from` parameter
        if ($from == 'my') {
            return redirect()->route('my.tanda-terima')->with('success', 'Tanda Terima updated successfully.');
        } elseif ($from == 'all') {
            return redirect()->route('all.tanda-terima')->with('success', 'Tanda Terima updated successfully.');
        }
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


        return $dompdf->stream($filePath, ['Attachment' => 0]);
    }
}
