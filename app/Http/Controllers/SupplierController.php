<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function showForm(){
        $suppliers = Supplier::all();
        return view('newtanda', ['suppliers' => $suppliers, 'title'=>'New Tanda Terima']);
    }
}
