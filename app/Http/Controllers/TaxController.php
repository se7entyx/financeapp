<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function getTax()
    {
        $title = 'All Taxes';
        $pajakRecords = Tax::sortable()->orderBy('name')->paginate(20)->withQueryString();

        return view('tax', ['pajakRecords' => $pajakRecords, 'title' => $title]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'percentage' => 'required|numeric',
            'type' => 'required|string'
        ]);

        Tax::create($validated);
        // $request->session()->flash('success', 'Registration successfull! Please Login!');
        return redirect('/dashboard/admin/tax')->with('success', 'Tax add successfully!');
    }

    public function updateTax(Request $request, $id)
    {
        // dd('panggil');
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'percentage' => 'required|numeric',
            'type' => 'required|string',
            'status' => 'required|string|in:active,inactive'
        ]);

        // dd($credentials);

        if ($credentials) {
            $tax = Tax::find($id);
            $tax->name = $credentials['name'];
            $tax->percentage = $credentials['percentage'];
            $tax->type = $credentials['type'];
            $tax->status = $credentials['status'];
            $tax->save();
            return redirect('/dashboard/admin/tax')->with('success', 'Update successfull!');
        } else {
            dd('asq');
        }
    }

    public function destroy($id)
    {
        $user = Tax::findOrFail($id);
        $user->delete();
        return redirect('/dashboard/admin/tax')->with('successdel', 'Delete successfull!');
    }
}
