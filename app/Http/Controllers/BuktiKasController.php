<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\KeteranganBuktiKas;
use App\Models\TandaTerima;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuktiKasController extends Controller
{
    protected $table = 'tanda_terima';
    public function index()
    {
        return  view('newbukti', [
            'title' => "New Bukti Pengeluaran Kas / Bank"
        ]);
    }
    public function getSupplierInfo(Request $request)
    {
        $tandaTerima = TandaTerima::with('supplier')->find($request->input('tanda_terima_id'));

        if ($tandaTerima) {
            return response()->json([
                'supplier_name' => $tandaTerima->supplier->name,
                'tanggal_jatuh_tempo' => $tandaTerima->tanggal_jatuh_tempo
            ]);
        }

        return response()->json(['error' => 'Tanda Terima not found'], 404);
    }
    public function store(Request $request)
    {

        // try {
        $userId = auth()->id();
        $validated = $request->validate([
            // 'user_id' => $userId,
            'tanda_terima_id_hidden' => 'required|exists:tanda_terima,id',
            'nomer' => 'required|string',
            'tanggal' => 'nullable|string',
            'kas' => 'required|string',
            'jumlah' => 'integer',
            'no_cek' => 'string',
            'hiddenBuktiField' => 'required|string'
        ]);
        // dd($validated);
        // }
        // catch (ValidationException $e) {
        //     dd($e->errors());
        // }

        $buktikas = new BuktiKas();
        $buktikas->user_id = $userId;
        $buktikas->tanda_terima_id = $validated['tanda_terima_id_hidden'];
        $buktikas->nomer = $validated['nomer'];
        $buktikas->tanggal = $validated['tanggal'];
        $buktikas->kas = $validated['kas'];
        $buktikas->jumlah = $validated['jumlah'];
        $buktikas->no_cek = $validated['no_cek'];

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

    // public function saveKeterangan(Request $request)
    // {
    //     $buktiData = $request->input('bukti');

    //     // Loop through each bukti item and save it to the database
    //     foreach ($buktiData as $bukti) {
    //         KeteranganBuktiKas::create([
    //             'bukti_kas_id' => DB::table('bukti_kas')->insertGetId([]),
    //             'notes' => $bukti['notes'],
    //             'dk' => $bukti['dk'],
    //             'nominal_value' => $bukti['nominalValue'],
    //         ]);
    //     }

    //     return response()->json(['success' => 'Keterangan bukti kas created successfully'], 200);
    // }
}
