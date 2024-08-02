<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class ExportTandaTerima implements WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $templatePath = storage_path('app/public/templates/template2.xlsx');
                if (!file_exists($templatePath)) {
                    throw new \Exception("Template file not found at path: $templatePath");
                }

                $spreadsheet = IOFactory::load($templatePath);
                $sheet = $spreadsheet->getActiveSheet();

                // Insert data into specific cells
                $sheet->setCellValue('H3', $this->data->increment_id ?? 'N/A');
                $sheet->setCellValue('G4', $this->data->tanggal ?? 'N/A');
                $sheet->setCellValue('D5', $this->data->supplier->name ?? 'N/A');
                $sheet->setCellValue('D7', $this->data->pajak == 'true' ? "\u{2713}" : "\u{2717}");
                $sheet->setCellValue('D8', $this->data->po == 'true' ? "\u{2713}" : "\u{2717}");
                $sheet->setCellValue('D9', $this->data->bpb == 'true' ? "\u{2713}" : "\u{2717}");
                $sheet->setCellValue('D10', $this->data->surat_jalan == 'true' ? "\u{2713}" : "\u{2717}");
                $sheet->setCellValue('E23', $this->data->tanggal_jatuh_tempo ?? 'N/A');
                $sheet->setCellValue('B25', $this->data->keterangan ?? 'N/A');

                $start = 15;
                foreach ($this->data->invoices as $invoice) {
                    $sheet->setCellValue('B' . $start, $invoice->nomor ?? 'N/A');
                    $sheet->setCellValue('F' . $start, $invoice->currency ?? 'N/A');
                    $sheet->setCellValue('G' . $start, $invoice->nominal ?? 'N/A');

                    $start++;
                }

                // Set print area and scaling
                $sheet->getPageSetup()->setPrintArea('A1:I27');
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(2);
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

                // Set margins
                $sheet->getPageMargins()->setTop(0);
                $sheet->getPageMargins()->setRight(0);
                $sheet->getPageMargins()->setLeft(0);
                $sheet->getPageMargins()->setBottom(0);

                // Save the file
                $filledTemplatePath = storage_path('app/public/templates/template2.xlsx');
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($filledTemplatePath);

                // Convert to PDF
                $pdfWriter = new Mpdf($spreadsheet);
                $pdfPath = storage_path('app/public/templates/filled_template2.pdf');
                $pdfWriter->save($pdfPath);

                if (!file_exists($pdfPath)) {
                    throw new \Exception("Failed to save the PDF file at path: $pdfPath");
                }

                return $this->sendToPrinter($pdfPath);
            },
        ];
    }

    public function sendToPrinter($pdfPath)
    {
        // Command to print PDF (for Unix-based systems using lp)
        $command = 'lp ' . escapeshellarg($pdfPath) . ' -o ColorModel=CMYK -o media=A4';
        // Execute the command
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return response()->json(['message' => 'Failed to send the document to the printer.'], 500);
        }

        return response()->json(['message' => 'Document sent to the printer successfully.']);
    }
}

