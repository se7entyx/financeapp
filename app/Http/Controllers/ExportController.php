<?php

namespace App\Http\Controllers;

use App\Exports\ExportTandaTerima;
use App\Http\Controllers\Controller;
use App\Models\TandaTerima;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function export($id)
    {
        // Fetch data from the database
        // dd($id);
        $data = TandaTerima::with(['supplier', 'user', 'invoices'])->find($id);
        // dd($data->id);

        // dd($data->supplier->name);

        if (!$data) {
            return response()->json(['message' => 'No data found'], 404);
        }

        // Create the export with data and save as Excel
        $export = new ExportTandaTerima($data);
        $excelPath = storage_path('app/public/templates/template2.xlsx');
        Excel::store($export, 'public/templates/filled_template2.xlsx');

        // Convert the filled Excel template to PDF
        $spreadsheet = IOFactory::load($excelPath);
        $pdfPath = storage_path('app/public/templates/filled_template2.pdf');
        $pdfWriter = new Mpdf($spreadsheet);
        $pdfWriter->save($pdfPath);

        // Ensure PDF exists
        if (!file_exists($pdfPath)) {
            return response()->json(['message' => 'Failed to save the PDF file.'], 500);
        }

        // Return a view that displays the PDF and triggers printing
        return view('print_pdf', ['pdfUrl' => asset('storage/templates/filled_template2.pdf')]);
    }
}

