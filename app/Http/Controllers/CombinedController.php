<?php

namespace App\Http\Controllers;

use App\Models\BuktiKas;
use App\Models\Invoices;
use App\Models\Supplier;
use App\Models\TandaTerima;
use Illuminate\Http\Request;

class CombinedController extends Controller
{
    //
    public function getTandaTerima()
    {
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->get();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        $title = 'All Document';
        return view('alldoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title, 'buktiKasRecords' => $buktiKasRecords, 'suppliers' => $suppliers]);
    }
    public function getBuktiKas()
    {
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->get();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        $title = 'All Document';
        return view('alldoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title, 'buktiKasRecords' => $buktiKasRecords, 'suppliers' => $suppliers]);
    }

    public function getMyTandaTerima()
    {
        $id = auth()->id();
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->where('user_id', $id)->get();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->where('user_id', $id)->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $title = 'My Documents';
        return view('mydoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title, 'buktiKasRecords' => $buktiKasRecords, 'suppliers' => $suppliers]);
    }

    public function getMyBuktiKas()
    {
        $id = auth()->id();
        $tandaTerimaRecords = TandaTerima::with(['supplier', 'user'])->where('user_id', $id)->get();
        $buktiKasRecords = BuktiKas::with(['tanda_terima', 'user'])->where('user_id', $id)->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        $title = 'My Documents';
        return view('mydoc', ['tandaTerimaRecords' => $tandaTerimaRecords, 'title' => $title, 'buktiKasRecords' => $buktiKasRecords, 'suppliers' => $suppliers]);
    }
}
