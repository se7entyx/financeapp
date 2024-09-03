<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\Invoices;
use App\Models\KeteranganBuktiKas;
use App\Models\Supplier;
use App\Models\TandaTerima;
use App\Models\Tax;
use App\Models\Transaction;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuktiKasController extends Controller
{
    protected $table = 'tanda_terima';

    public function getBuktiKas()
    {
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->filter(request(['search', 'jatuh_tempo']))->sortable()->latest()->paginate(20)->withQueryString();
        $title = 'All Document';
        return view('alldoc2', ['title' => $title, 'buktiKasRecords' => $buktiKasRecords]);
    }


    public function getMyBuktiKas()
    {
        $id = Auth::id();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])
            ->where('bukti_kas.user_id', $id)
            ->sortable()
            ->filter(request(['search', 'jatuh_tempo']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $title = 'My Bukti Pengeluaran Kas';
        return view('mydoc2', ['title' => $title, 'buktiKasRecords' => $buktiKasRecords]);
    }


    public function index()
    {
        $userId = Auth::id();

        // Fetch TandaTerima records that are not assigned to BuktiKas
        $tandaTerimaQuery = TandaTerima::with('supplier', 'invoices')
            ->leftJoin('bukti_kas', 'tanda_terima.id', '=', 'bukti_kas.tanda_terima_id')
            ->where('tanda_terima.user_id', $userId) // Specify table name to avoid ambiguity
            ->whereNull('bukti_kas.tanda_terima_id') // Ensure there's no corresponding bukti_kas record
            ->select('tanda_terima.*');

        $tandaTerimas = $tandaTerimaQuery->get();
        $ppn = Tax::where('type', 'ppn')->where('status','active')->get();
        $pph = Tax::where('type', 'pph')->where('status','active')->get();

        return view('newbukti', [
            'title' => "New Bukti Pengeluaran Kas / Bank",
            'tandaTerimas' => $tandaTerimas,
            'ppn' => $ppn,
            'pph' => $pph
        ]);
    }

    public function getSupplierInfo($tandaTerimaInc, $buktiKasId = null)
    {
        try {
            $userId = Auth::id();

            $tandaTerima = TandaTerima::with(['supplier', 'invoices', 'bukti_kas'])
                ->where('user_id', $userId)
                ->where('increment_id', $tandaTerimaInc)
                ->first();

            if ($tandaTerima) {
                if ($tandaTerima->bukti_kas && $tandaTerima->bukti_kas->id !== $buktiKasId) {
                    return response()->json(['error' => 'Tanda Terima already assigned to a different Bukti Kas'], 400);
                }

                $invoiceData = [];
                foreach ($tandaTerima->invoices as $invoice) {
                    foreach ($invoice->transaction as $transaction) {
                        $invoiceData[] = [
                            'invoice_id' => $invoice->id,
                            'invoice_keterangan' => $invoice->nomor,
                            'transaction_id' => $transaction->id,
                            'transaction_keterangan' => $transaction->keterangan,
                            'transaction_nominal' => $transaction->nominal,
                            'nominal_setelah' => $transaction->nominal_setelah,
                            'nominal_ppn' => $transaction->nominal_ppn,
                            'nominal_pph' => $transaction->nominal_pph,
                            'id_ppn' => $transaction->id_ppn,
                            'id_pph' => $transaction->id_pph,
                            'currency' => $tandaTerima->currency,
                        ];
                    }
                }

                // Log the final invoiceData array

                return response()->json([
                    'supplier_name' => $tandaTerima->supplier->name,
                    'tanggal_jatuh_tempo' => $tandaTerima->tanggal_jatuh_tempo,
                    'tanda_terima_id' => $tandaTerima->id,
                    'invoiceData' => $invoiceData
                ]);
            }

            return response()->json(['error' => 'Tanda Terima not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching supplier info: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
            'nomer' => 'required|string',
            'kas' => 'required|string',
            'jumlah' => 'numeric',
            'no_cek' => 'nullable|string',
            'berita_transaksi' => 'required|string',
            'keterangan' => 'nullable|string',
            'bukti_data' => 'required|json'
        ]);

        try {
            $userId = Auth::id();

            // Create and save BuktiKas
            $buktikas = new BuktiKas();
            $buktikas->user_id = $userId;
            $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
            $buktikas->nomer = $validated['nomer'];
            $buktikas->tanggal = null;
            $buktikas->kas = $validated['kas'];
            $buktikas->jumlah = $validated['jumlah'];
            $buktikas->no_cek = $validated['no_cek'];
            $buktikas->berita_transaksi = $validated['berita_transaksi'];
            $buktikas->keterangan = $validated['keterangan'];

            $buktikas->save();

            // Decode bukti_data and update transactions
            $buktiArray = json_decode($validated['bukti_data'], true);

            foreach ($buktiArray as $item) {
                $transaction = Transaction::find($item['transaction_id']);
                if ($transaction) {
                    $transaction->id_ppn = $item['ppnid'];
                    $transaction->nominal_ppn = $item['ppnNominal'];
                    $transaction->id_pph = $item['pphid'];
                    $transaction->nominal_pph = $item['pphNominal'];
                    $transaction->save();
                }
            }

            return redirect()->route('buktikas.index')->with('success', 'Bukti Kas created successfully!');
        } catch (ValidationException $e) {
            dd($e);
        } catch (\Exception $e) {
            Log::error('Error storing Bukti Kas: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the Bukti Kas.']);
        }
    }


    public function deleteBk($id)
    {
        $x = BuktiKas::find($id);
        $x->delete();

        return back()->with('success', 'Action completed successfully!');
    }
    public function showEditForm($id)
    {
        $buktikas = BuktiKas::with(['tanda_terima.supplier', 'tanda_terima.invoices'])->findOrFail($id);

        $title = 'Edit Bukti Kas';
        $userId = Auth::id();

        // Create a base query for TandaTerima
        $tandaTerimaQuery = TandaTerima::with('supplier', 'invoices')
            ->leftJoin('bukti_kas', 'tanda_terima.id', '=', 'bukti_kas.tanda_terima_id')
            ->where('tanda_terima.user_id', $userId);

        // Check if $id is provided
        if ($id) {
            // Find the specific BuktiKas record
            $buktiKas = BuktiKas::find($id);

            if ($buktiKas) {
                // Include the TandaTerima associated with the current BuktiKas being edited
                $tandaTerimaQuery->where(function ($query) use ($buktiKas) {
                    $query->whereNull('bukti_kas.tanda_terima_id')
                        ->orWhere('tanda_terima.id', $buktiKas->tanda_terima_id);
                });
            } else {
                // If BuktiKas is not found, still exclude those assigned to BuktiKas
                $tandaTerimaQuery->whereNull('bukti_kas.tanda_terima_id');
            }
        } else {
            // Exclude those assigned to BuktiKas
            $tandaTerimaQuery->whereNull('bukti_kas.tanda_terima_id');
        }

        $tandaTerimaOption = $tandaTerimaQuery->select('tanda_terima.*')->get();
        $ppn = Tax::where('type', 'ppn')->where('status','active')->get();
        $pph = Tax::where('type', 'pph')->where('status','active')->get();

        return view('editdoc2', [
            'buktiKasRecords' => $buktikas,
            'title' => $title,
            'tandaTerimas' => $tandaTerimaOption,
            'ppn' => $ppn,
            'pph' => $pph
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
            'nomer' => 'required|string',
            'kas' => 'required|string',
            'jumlah' => 'numeric',
            'no_cek' => 'nullable|string',
            'berita_transaksi' => 'required|string',
            'keterangan' => 'nullable|string',
            'bukti_data' => 'required|json'
        ]);

            // Find and update BuktiKas record
            $buktikas = BuktiKas::findOrFail($id);
            $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
            $buktikas->nomer = $validated['nomer'];
            $buktikas->kas = $validated['kas'];
            $buktikas->jumlah = $validated['jumlah'];
            $buktikas->no_cek = $validated['no_cek'];
            $buktikas->berita_transaksi = $validated['berita_transaksi'];
            $buktikas->save();

            // Decode bukti_data and update transactions
            $buktiArray = json_decode($validated['bukti_data'], true);

            foreach ($buktiArray as $item) {
                $transaction = Transaction::find($item['transaction_id']);
                if ($transaction) {
                    $transaction->id_ppn = $item['ppnid'];
                    $transaction->nominal_ppn = $item['ppnNominal'];
                    $transaction->id_pph = $item['pphid'];
                    $transaction->nominal_pph = $item['pphNominal'];
                    $transaction->save();
                }
            }

            return redirect()->route('my.bukti-kas')->with('success', 'Bukti Kas updated successfully.');
    }


    public function finish(Request $request, $id)
    {
        $validated = $request->validate([
            'nomer' => 'required|string',
            'tanggal' => 'required|string'
        ]);

        $buktikas = BuktiKas::findOrFail($id);
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = $validated['tanggal'];
        $buktikas->status = "Sudah dibayar";
        $buktikas->save();

        return redirect()->route('my.bukti-kas')->with('success', 'Bukti Kas Updated successfully.');
    }

    public function printBuktiKas($id)
    {
        $buktiKas = BuktiKas::with(['tanda_terima'])->find($id);
        $tandaTerima = TandaTerima::find($buktiKas->tanda_terima_id);
        $invoiceData = [];

        foreach ($tandaTerima->invoices as $invoice) {
            foreach ($invoice->transaction as $transaction) {
                $taxPpn = Tax::where('id', $transaction->id_ppn)->first();
                $taxPph = Tax::where('id', $transaction->id_pph)->first();

                $invoiceData[] = [
                    'invoice_id' => $invoice->id,
                    'invoice_keterangan' => $invoice->nomor,
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
        
        $html = view('print2', compact('buktiKas', 'invoiceData'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $filePath = storage_path('app/public/bukti_kas.pdf');
        file_put_contents($filePath, $output);

        // Send PDF to printer
        $fileUrl = asset('storage/bukti_kas.pdf');
        return redirect($fileUrl);
    }

    public function printMandiri($id)
    {
        $buktiKas = BuktiKas::with(['tanda_terima'])->find($id);
        // return view('printMandiri',compact('buktiKas'))
        $htmlContent = view('printmandiri', compact('buktiKas'))->render();
        // Initialize dompdf and set options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parsing
        $options->set('isPhpEnabled', false); // Disable PHP in HTML (if not needed)
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($htmlContent);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Save the PDF to the storage directory
        $pdfFilePath = storage_path('app/public/mandiri.pdf');
        $dompdf->stream($pdfFilePath, ['Attachment' => 0]);
    }
}
