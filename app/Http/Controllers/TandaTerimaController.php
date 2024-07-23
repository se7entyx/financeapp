<?php

namespace App\Http\Controllers;

use App\Models\TandaTerima;
use Illuminate\Http\Request;

class TandaTerimaController extends Controller
{
    public function store(Request $request){
        dd($request);   
        $userId = auth()->id();
        $validated = $request->validate([
            'user_id' => $userId,
            'tanggal' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'pajak' => 'boolean',
            'po' => 'boolean',
            'bpb' => 'boolean',
            'surat_jalan' => 'boolean',
            'tanggal_jatuh_tempo' => 'required|date',
            'notes' => 'text',
        ]);

        $tandaterima = new TandaTerima();
        $tandaterima->supplier_id = $validated['supplier_id'];
        $tandaterima->tanggal = $validated['tanggal'];
        $tandaterima->notes = $validated['notes'];  
        $tandaterima->pajak = $validated['pajak'];
        $tandaterima->po = $validated['po'];
        $tandaterima->bpb = $validated['bpb'];
        $tandaterima->surat_jalan = $validated['surat_jalan'];
        $tandaterima->tanggal_jatuh_tempo = $validated['tanggal_jatuh_tempo'];
        // $tandaterima->no_invoice = $validated['noinvoiceinput'];
        // $tandaterima->nominal = $validated['nominal'];
        $tandaterima->user_id = $userId; // Set the user ID if needed
        $tandaterima->save();
        // TandaTerima::create($validated);

        return redirect('/dashboard');  
    }
}
