<?php

namespace App\Http\Controllers;

use App\Models\TandaTerima;
use Illuminate\Http\Request;

class TandaTerimaController extends Controller
{
    public function store(Request $request){
        // dd('Function is called');
        $userId = auth()->id();
        $validated = $request->validate([
            // 'user_id' => $userId,
            'tanggal' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'faktur' => 'nullable|string',
            'po' => 'nullable|string',
            'bpb' => 'nullable|string',
            'sjalan' => 'nullable|string',
            'jatuh_tempo' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $tandaterima = new TandaTerima();
        // TandaTerima::create();
        $tandaterima->user_id = $userId;
        $tandaterima->tanggal = $validated['tanggal'];
        $tandaterima->supplier_id = $validated['supplier_id'];
        $tandaterima->pajak = $validated['faktur'];
        $tandaterima->po = $validated['po'];
        $tandaterima->bpb = $validated['bpb'];
        $tandaterima->surat_jalan = $validated['sjalan'];
        $tandaterima->tanggal_jatuh_tempo = $validated['jatuh_tempo'];
        $tandaterima->keterangan = $validated['notes'];
        // $tandaterima->no_invoice = $validated['noinvoiceinput'];
        // $tandaterima->nominal = $validated['nominal'];
        // $tandaterima->user_id = $userId;
        // Set the user ID if needed
        // dd($validated, $tandaterima);

        $tandaterima->save();
        // TandaTerima::create($validated);

        return redirect()->route('newtanda')->with('success', 'Tanda Terima created successfully!');
    }
}
