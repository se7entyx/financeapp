<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\TandaTerima;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function showForm()
    {
        // Fetch all suppliers from the database
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $usedPONumbers = TandaTerima::pluck('nomor_po')->toArray();
        // Return the view 'newtanda' with the suppliers and a title
        return view('newtanda', ['suppliers' => $suppliers, 'usedPONumbers' => $usedPONumbers , 'title' => 'New Tanda Terima']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255|string',
                'norek' => 'required|max:255|string',
                'bank' => 'required|string'
            ]
        );

        $supplier = new Supplier();
        $supplier->name = $validatedData['name'];
        $supplier->no_rek =  $validatedData['norek'];
        $supplier->bank = $validatedData['bank'];
        $supplier->save();

        return redirect('/dashboard/admin/suppliers')->with('success', 'Registration successfull!');
    }

    public function updateSupplier(Request $request, $id)
    {
        // dd('panggil');
        $credentials = $request->validate([
            'name' => 'required|max:255|string',
            'norek' => 'required|max:255|string',
            'bank' => 'required|string'
        ]);

        // dd($credentials);

        if ($credentials) {
            $supplier = Supplier::find($id);
            $supplier->name = $credentials['name'];
            $supplier->no_rek = $credentials['norek'];
            $supplier->bank = $credentials['bank'];
            $supplier->save();
            return redirect('/dashboard/admin/suppliers')->with('success', 'Update successfull!');
        } else {
            dd('asq');
        }
    }

    public function getSuppliers(Request $request)
    {
        $suppliers = Supplier::search()->latest()->paginate(20)->withQueryString();
        return view('supplier', ['title' => 'All Suppliers', 'suppliers' => $suppliers]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect('/dashboard/admin/suppliers')->with('successdel', 'Delete successfull!');
    }
}
