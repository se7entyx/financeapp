<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\Invoices;
use App\Models\KeteranganBuktiKas;
use App\Models\TandaTerima;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Get the current user ID
        $userId = Auth::id();

        // Fetch all TandaTerima records with the associated suppliers for the authenticated user using eager loading
        $tandaTerima = TandaTerima::with('supplier', 'user')
            ->where('user_id', $userId)
            ->find($request->input('tanda_terima_id'));

        // Prepare the response data
        if ($tandaTerima) {
            return response()->json([
                'supplier_name' => $tandaTerima->supplier->name,
                'tanggal_jatuh_tempo' => $tandaTerima->tanggal_jatuh_tempo
            ]);
        }

        // Return the supplier data as a JSON response
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

        return response()->with('success', 'Bukti Kas deleted successfully!');
    }
}
