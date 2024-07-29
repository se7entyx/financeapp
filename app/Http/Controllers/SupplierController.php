<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function showForm(){
        // Fetch all suppliers from the database
        $suppliers = Supplier::all();
        // Return the view 'newtanda' with the suppliers and a title
        return view('newtanda', ['suppliers' => $suppliers, 'title' => 'New Tanda Terima']);
    }

    // public function showAll(){
    //     // Fetch all suppliers from the database
    //     $suppliers = Supplier::all();
    //     dd($suppliers);// Return the view 'alldoc' with the suppliers
    //     return view('alldoc', ['suppliers1' => $suppliers]);
    // }
}
