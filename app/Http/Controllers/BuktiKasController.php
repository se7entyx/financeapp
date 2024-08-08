<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\Invoices;
use App\Models\KeteranganBuktiKas;
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

        // Fetch TandaTerima records that are not assigned to BuktiKas, or are assigned to the current BuktiKas being edited
        $tandaTerimaQuery = TandaTerima::with('supplier', 'invoices')
            ->where('user_id', $userId)
            ->where('increment_id', $tandaTerimaInc);

        // if ($buktiKasId) {
        //     $buktiKas = BuktiKas::find($buktiKasId);

        //     if ($buktiKas) {
        //         // Include the TandaTerima associated with the current BuktiKas being edited
        //         $tandaTerimaQuery->where(function ($query) use ($buktiKas) {
        //             $query->whereDoesntHave('bukti_kas')
        //                 ->orWhere('id', $buktiKas->tanda_terima_id);
        //         });
        //     } else {
        //         // If BuktiKas is not found, still exclude those assigned to BuktiKas
        //         $tandaTerimaQuery->whereDoesntHave('bukti_kas');
        //     }
        // } else {
        //     // Exclude those assigned to BuktiKas
        //     $tandaTerimaQuery->whereDoesntHave('bukti_kas');
        // }

        $tandaTerima = $tandaTerimaQuery->first();

        // Prepare the response data
        if ($tandaTerima) {
            return response()->json([
                'supplier_name' => $tandaTerima->supplier->name,
                'tanggal_jatuh_tempo' => $tandaTerima->tanggal_jatuh_tempo,
                'tanda_terima_id' => $tandaTerima->id,
                'currency' => $tandaTerima->currency
            ]);
        }

        // Return an error if TandaTerima not found
        return response()->json(['error' => 'Tanda Terima not found or already used'], 404);
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            $userId = auth()->id();
            $validated = $request->validate([
                // 'user_id' => $userId,
                'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
                'nomer' => 'required|string',
                'tanggal' => 'nullable|string',
                'kas' => 'required|string',
                'jumlah' => 'integer',
                'no_cek' => 'string',
                'berita_transaksi' => 'required|string',
                'hiddenBuktiField' => 'required|string'
            ]);
            // dd($validated);
        } catch (ValidationException $e) {
            dd($validated);
        }
        $buktikas = new BuktiKas();
        $buktikas->user_id = $userId;
        $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = $validated['tanggal'];
        $buktikas->kas = $validated['kas'];
        $buktikas->jumlah = $validated['jumlah'];
        $buktikas->no_cek = $validated['no_cek'];
        $buktikas->berita_transaksi = $validated['berita_transaksi'];

        $buktikas->save();

        $buktiArray = json_decode($request->input('hiddenBuktiField'), true);

        foreach ($buktiArray as $buktiItem) {
            // Example: Save each item to the database
            KeteranganBuktiKas::create([
                'bukti_kas_id' => $buktikas->id,
                'keterangan' => $buktiItem['notes'],
                'dk' => $buktiItem['dk'],
                'jumlah' => $buktiItem['nominalValue']
            ]);
        }

        return redirect()->route('buktikas.index')->with('success', 'Bukti Kas created successfully!');
    }

    public function showAll()
    {
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->get();
        $currency = Invoices::with(['tanda_terima'])->where('id', $buktiKasRecords->tanda_terima->id)->pluck('currency')->first();
        return view('alldoc', ['title' => 'All Document', 'buktiKasRecords' => $buktiKasRecords, 'currency' => $currency]);
    }

    public function getDetails($id)
    {
        // Fetch the BuktiKas record along with its related KeteranganBuktiKas records
        $buktiKas = BuktiKas::with('keterangan_bukti_kas')->findOrFail($id);

        return response()->json($buktiKas);
    }
    public function deleteBk($id)
    {
        $x = BuktiKas::find($id);
        $x->delete();

        return redirect()->route('my.bukti-kas')->with('success', 'Bukti Kas deleted successfully.');
    }
    public function showEditForm($id)
    {
        $buktikas = BuktiKas::with(['keterangan_bukti_kas', 'tanda_terima.supplier', 'tanda_terima.invoices'])->findOrFail($id);

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
            'tanggal' => 'nullable|string',
            'kas' => 'required|string',
            'jumlah' => 'integer',
            'no_cek' => 'string',
            'berita_transaksi' => 'required|string',
            'hiddenBuktiField' => 'required|string'
        ]);

        $buktikas = BuktiKas::findOrFail($id);
        $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = $validated['tanggal'];
        $buktikas->kas = $validated['kas'];
        $buktikas->jumlah = $validated['jumlah'];
        $buktikas->no_cek = $validated['no_cek'];
        $buktikas->berita_transaksi = $validated['berita_transaksi'];
        $buktikas->save();

        $buktiArray = json_decode($request->input('hiddenBuktiField'), true);


        $existingBuktiKasIds = KeteranganBuktiKas::where('bukti_kas_id', $id)->pluck('id')->toArray();

        // Create an array to keep track of processed IDs
        $processedIds = [];

        foreach ($buktiArray as $buktiItem) {
            if (isset($buktiItem['id'])) {
                // Update existing record
                $updatedKeterangan = KeteranganBuktiKas::findOrFail($buktiItem['id']);
                $updatedKeterangan->keterangan = $buktiItem['notes'];
                $updatedKeterangan->dk = $buktiItem['dk'];
                $updatedKeterangan->jumlah = $buktiItem['nominalValue'];
                $updatedKeterangan->save();

                // Add the processed ID to the array
                $processedIds[] = $buktiItem['id'];
            } else {
                // Create new record
                $newKeterangan = new KeteranganBuktiKas();
                $newKeterangan->bukti_kas_id = $id;
                $newKeterangan->keterangan = $buktiItem['notes'];
                $newKeterangan->dk = $buktiItem['dk'];
                $newKeterangan->jumlah = $buktiItem['nominalValue'];
                $newKeterangan->save();

                // Add the new ID to the processed IDs
                $processedIds[] = $newKeterangan->id;
            }
        }

        // Find IDs to delete (existing IDs that were not processed)
        $idsToDelete = array_diff($existingBuktiKasIds, $processedIds);
        KeteranganBuktiKas::whereIn('id', $idsToDelete)->delete();

        return redirect()->route('my.bukti-kas')->with('success', 'Bukti Kas Updated successfully.');
    }

    public function printBuktiKas($id)
    {
        $buktiKas = BuktiKas::with(['tanda_terima', 'keterangan_bukti_kas'])->find($id);

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
