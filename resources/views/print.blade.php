<!DOCTYPE html>
<html>

<head>
    <title>Print Tanda Terima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            transform: scale(0.9);
            /* Scale down the content */
            transform-origin: top left;
        }

        @page {
            size: A4 portrait;
            margin: 0;
            /* Remove page margins */
        }

        .page {
            width: 100%;
            height: 50%;
            /* Reduce the height to fit two pages */
            box-sizing: border-box;
            padding: 10px;
            position: relative;
            /* page-break-after: always; */
        }

        .container {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 10px;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .no-border {
            border: none;
        }

        .icon {
            font-family: DejaVu Sans, sans-serif;
        }

        .red {
            color: red;
        }

        .table-bordered {
            border: 1px solid black;
        }

        .table-bordered td {
            border: 1px solid black;
        }

        .large-bold {
            font-size: 2em;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="container">
            <table>
                <tr>
                    <td colspan="4" class="center large-bold">Tanda Terima</td>
                </tr>
                <tr>
                    <td colspan="2" class="bold">PT INDRA ERAMULTI LOGAM INDUSTRI</td>
                    <td class="right">No. <span class="red">{{ str_pad($tandaTerima->increment_id, 6, '0', STR_PAD_LEFT) }}</span></td>
                </tr>
                <tr>
                    <td colspan="4" class="right">Tanggal, {{ $tandaTerima->tanggal }}</td>
                </tr>
                <tr>
                    <td>Terima dari</td>
                    <td colspan="3">{{ $tandaTerima->supplier->name }}</td>
                </tr>
                <tr>
                    <td>Faktur Pajak</td>
                    <td class="icon">{{ $tandaTerima->faktur_pajak ? '✔' : '✘' }}</td>
                    <td>PO</td>
                    <td class="icon">{{ $tandaTerima->po ? '✔' : '✘' }}</td>
                </tr>
                <tr>
                    <td>BPB</td>
                    <td class="icon">{{ $tandaTerima->bpb ? '✔' : '✘' }}</td>
                    <td>Surat Jalan</td>
                    <td class="icon">{{ $tandaTerima->surat_jalan ? '✔' : '✘' }}</td>
                </tr>
                <tr>
                    <td>Kwitansi/Nota</td>
                </tr>
            </table>

            <table class="table-bordered">
                <thead>
                    <tr>
                        <td class="bold" style="width: 25%;">No Invoice</td>
                        <td class="bold" style="width: 25%;"></td>
                        <td class="bold" style="width: 50%;">Nominal</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalRows = 6; // Total number of rows you want in the table
                    $invoiceCount = $tandaTerima->invoices->count();
                    $rowsToGenerate = max($totalRows, $invoiceCount);
                    @endphp

                    @foreach ($tandaTerima->invoices as $invoice)
                    <tr>
                        <td style="width: 25%;">{{ $invoice->nomor }}</td>
                        <td style="width: 25%;">{{ $tandaTerima->currency }}</td>
                        <td style="width: 50%;">{{ number_format($invoice->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    @for ($i = $invoiceCount; $i < $totalRows; $i++) <tr>
                        <td style="color: white; width: 25%;">&nbsp;</td>
                        <td style="color: white; width: 25%;">&nbsp;</td>
                        <td style="color: white; width: 50%;">&nbsp;</td>
                        </tr>
                        @endfor
                </tbody>
            </table>

            <table class="footer-table">
                <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td colspan="2">{{ $tandaTerima->tanggal_jatuh_tempo }}</td>
                    <td class="center">Yang Menerima,</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="3">{{ $tandaTerima->keterangan }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="center">........................................</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>