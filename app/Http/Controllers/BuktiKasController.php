<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\Invoices;
use App\Models\KeteranganBuktiKas;
use App\Models\Supplier;
use App\Models\TandaTerima;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuktiKasController extends Controller
{
    protected $table = 'tanda_terima';

    public function getBuktiKas()
    {
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->filter(request(['search', 'jatuh_tempo']))->sortable(['created_at' => 'asc'])->latest()->paginate(20)->withQueryString();
        $title = 'All Document';
        return view('alldoc2', ['title' => $title, 'buktiKasRecords' => $buktiKasRecords]);
    }


    public function getMyBuktiKas()
    {
        $id = Auth::id();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])
            ->where('bukti_kas.user_id', $id)
            ->sortable(['created_at' => 'asc'])
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

        return view('newbukti', [
            'title' => "New Bukti Pengeluaran Kas / Bank",
            'tandaTerimas' => $tandaTerimas
        ]);
    }
    public function getSupplierInfo($tandaTerimaInc, $buktiKasId = null)
    {
        // Get the current user ID
        $userId = Auth::id();

        // Fetch TandaTerima records with related supplier, invoices, and buktiKas
        $tandaTerimaQuery = TandaTerima::with(['supplier', 'invoices', 'bukti_kas'])
            ->where('user_id', $userId)
            ->where('increment_id', $tandaTerimaInc);

        $tandaTerima = $tandaTerimaQuery->first();

        // Check if TandaTerima is found
        if ($tandaTerima) {
            // If buktiKasId is provided and TandaTerima is already assigned to a different BuktiKas, return an error
            if ($tandaTerima->bukti_kas && $tandaTerima->bukti_kas->id !== $buktiKasId) {
                return response()->json(['error' => 'Tanda Terima already assigned to a different Bukti Kas'], 400);
            }

            // Prepare the response data
            return response()->json([
                'supplier_name' => $tandaTerima->supplier->name,
                'tanggal_jatuh_tempo' => $tandaTerima->tanggal_jatuh_tempo,
                'tanda_terima_id' => $tandaTerima->id,
                'invoices' => $tandaTerima->invoices,
                'currency' => $tandaTerima->currency
            ]);
        }

        // Return an error if TandaTerima not found
        return response()->json(['error' => 'Tanda Terima not found'], 404);
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            $userId = Auth::id();
            $validated = $request->validate([
                // 'user_id' => $userId,
                'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
                'nomer' => 'required|string',
                'kas' => 'required|string',
                'jumlah' => 'integer',
                'no_cek' => 'nullable|string',
                'berita_transaksi' => 'required|string'
            ]);
            // dd($validated);
        } catch (ValidationException $e) {
            dd($e);
        }
        $buktikas = new BuktiKas();
        $buktikas->user_id = $userId;
        $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = null;
        $buktikas->kas = $validated['kas'];
        $buktikas->jumlah = $validated['jumlah'];
        $buktikas->no_cek = $validated['no_cek'];
        $buktikas->berita_transaksi = $validated['berita_transaksi'];

        $buktikas->save();

        return redirect()->route('buktikas.index')->with('success', 'Bukti Kas created successfully!');
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

        return view('editdoc2', [
            'buktiKasRecords' => $buktikas,
            'title' => $title,
            'tandaTerimas' => $tandaTerimaOption
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate Tanda Terima data
        $validated = $request->validate([
            'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
            'nomer' => 'required|string',
            'kas' => 'required|string',
            'jumlah' => 'integer',
            'no_cek' => 'nullable|string',
            'berita_transaksi' => 'required|string'
        ]);

        $buktikas = BuktiKas::findOrFail($id);
        $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = null;
        $buktikas->kas = $validated['kas'];
        $buktikas->jumlah = $validated['jumlah'];
        $buktikas->no_cek = $validated['no_cek'];
        $buktikas->berita_transaksi = $validated['berita_transaksi'];
        $buktikas->save();

        return redirect()->route('my.bukti-kas')->with('success', 'Bukti Kas Updated successfully.');
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

        $html = view('print2', compact('buktiKas'))->render();

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
