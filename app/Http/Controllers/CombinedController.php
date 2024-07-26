<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\TandaTerima;
use Illuminate\Http\Request;

class CombinedController extends Controller
{
    //
    public function getTandaTerima() {
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->get();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->get();

        $title = 'All Document';
        return view('alldoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title, 'buktiKasRecords' => $buktiKasRecords]);
    }

    public function getBuktiKas() {
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->get();
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->get();

        $title = 'All Document';
        return view('alldoc', ['buktiKasRecords' => $buktiKasRecords, 'title' => $title, 'tandaTerimaRecords' => $tandaTerimaRecords]);
    }
}
