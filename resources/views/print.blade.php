<!DOCTYPE html>
<html>

<head>
    <title>Tanda Terima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            height: 50%;
            padding: 10px;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid black;
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
            font-size: 1.5em;
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
                    <td colspan="3">{{ $tandaTerima->kwitansi_nota }}</td>
                </tr>
            </table>

            <table class="table-bordered">
                <thead>
                    <tr>
                        <td class="bold">No Invoice</td>
                        <td class="bold"></td>
                        <td class="bold">Nominal</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tandaTerima->invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->nomor }}</td>
                        <td>{{ $tandaTerima->currency }}</td>
                        <td>{{ number_format($invoice->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td>{{ $tandaTerima->tanggal_jatuh_tempo }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td colspan="2"></td>
                    <td class="center">Yang Menerima,</td>
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
<script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.location.href = "/"; // Redirect or close window after printing
            };
        }
    </script>
</html>