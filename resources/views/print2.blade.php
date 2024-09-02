<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bukti Pengeluaran Kas / Bank</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            margin: 0;
            padding: 0;
            transform: scale(0.9);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        .container {
            width: 100%;
            height: 55.5%;
            margin: 0 auto;
            border: 3px double black;
            box-sizing: border-box;
            padding: 10px;
            position: relative;
            transform: translate(-5mm, -7mm);
        }

        table.x {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table.xy {
            padding-top: 20px;
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table.xz {
            width: 100%;
            border-collapse: separate;
            font-size: 14px;
        }

        .xz td {
            padding: 7px;
        }

        .ver-align {
            vertical-align: middle;
        }

        th,
        td {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
        }

        .no-border {
            border: none;
        }

        .title {
            font-size: 18px;
        }

        .center-text {
            text-align: center;
        }

        .right-text {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        table.signature {
            padding-inline: 20px;
            padding-top: 25px;
            border-collapse: collapse;
            font-size: 11px;
            transform: translateX(5mm);
        }

        .signature th {
            text-align: center;
        }

        .no-border-block {
            border-top: none;
            border-bottom: none;
        }

        .no-border-top {
            border-top: none;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
    $totalRowsPerPage = 10; // Total rows per page
    $currentRow = 0;
    $grandTotal = 0.0;
    $accumulate = 0.0;
    $x = 0;
    $y = '';
    $yrow = '';
    $carryOverRow = null;
    @endphp

    @foreach ($invoiceData as $index => $trans)
    @if($currentRow % $totalRowsPerPage == 0)
    <div class="container">
        <table class="xz">
            <!-- Table header code -->
            <tr>
                <td class="title align-left no-border" style="width: 310px;">PT Indra Eramulti Logam Industri</td>
                <td class="no-border ver-align align-left" style="width:40px">Nomer</td>
                <td class="center-text border" style="width: 120px;">{{ $buktiKas->nomer }}</td>
            </tr>
            <tr>
                <td class="no-border" style="width: 310px;"></td>
                <td class="no-border ver-align" style="width:40px">Tanggal</td>
                <td class="center-text border" style="width: 120px;">{{ $buktiKas->tanggal ?? '' }}</td>
            </tr>
            <tr>
                <td class=" title center-text no-border" colspan="3">BUKTI PENGELUARAN KAS / BANK</td>
            </tr>
        </table>

        <table class="x">
            <!-- Supplier details and other information -->
            <tr>
                <td class="no-border align-left">Dibayarkan kepada</td>
                <td class="no-border">: {{$buktiKas->tanda_terima->supplier->name}}</td>
            </tr>
            <tr>
                <td class="no-border align-left">Kas/Cheque/Bilyet Giro Bank</td>
                <td class="no-border">: {{$buktiKas->kas}}</td>
            </tr>
            <tr>
                <td class="no-border align-left">Jumlah USD / Rp</td>
                <td class="no-border">: {{$buktiKas->tanda_terima->currency}} {{number_format($buktiKas->jumlah, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="no-border align-left">No. cek</td>
                <td class="no-border">: {{$buktiKas->no_cek}}</td>
            </tr>
            <tr>
                <td class="no-border" style="width: 200px;">Tanggal jatuh tempo</td>
                <td class="no-border">: {{$buktiKas->tanda_terima->tanggal_jatuh_tempo}}</td>
            </tr>
        </table>

        <table class="xy">
            <tr>
                <th class="center-text">No. Perkiraan</th>
                <th class="center-text">Nama Perkiraan</th>
                <th class="center-text">Keterangan</th>
                <th class="center-text">D/K</th>
                <th class="center-text">Jumlah</th>
            </tr>
            @endif

            @if (is_array($carryOverRow) && isset($carryOverRow['invoice_keterangan']) && $y != '(' . $carryOverRow['invoice_keterangan'] . ')')
            @php
                $y = '(' . $carryOverRow['invoice_keterangan'] . ')';
                $yrow = '(' . $carryOverRow['invoice_keterangan'] . ')';
            @endphp
            @else
            @php
                $yrow = '';
            @endphp
            @endif

            <!-- Handle carry over row from previous page -->
            @if($carryOverRow && $currentRow < $totalRowsPerPage)
            @if($carryOverRow['transaction_keterangan'])
            <tr>
                <td></td>
                <td></td>
                <td>{{ $carryOverRow['transaction_keterangan'] }} {{$yrow}}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['transaction_nominal'], 0, ',', '.') }}</td>
            </tr>
            @php
            $currentRow += 1;
            $accumulate += $carryOverRow['transaction_nominal'];
            @endphp
            @endif
            @if ($carryOverRow['name_ppn'])
            <tr>
                <td></td>
                <td></td>
                <td>{{ $carryOverRow['name_ppn'] }}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['nominal_ppn'], 0, ',', '.') }}</td>
            </tr>
            @php
            $currentRow += 1;
            $accumulate += $carryOverRow['nominal_ppn'];
            @endphp
            @endif
            @if ($carryOverRow['name_pph'])
            <tr>
                <td></td>
                <td></td>
                <td>{{ $carryOverRow['name_pph'] }}</td>
                <td class="center-text"></td>
                <td class="right-text" style="color: red;">({{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['nominal_pph'], 0, ',', '.') }})</td>
            </tr>
            @php
            $currentRow += 1;
            $accumulate += $carryOverRow['nominal_pph'];
            @endphp
            @endif
            @php 
            $carryOverRow = null;
            @endphp
            @endif

            @if ($y != '(' . $trans['invoice_keterangan'] . ')')
            @php
                $y = '(' . $trans['invoice_keterangan'] . ')';
                $yrow = '(' . $trans['invoice_keterangan'] . ')';
            @endphp
            @else
            @php
                $yrow = '';
            @endphp
            @endif

            <!-- Transaction Row -->
            @if($trans['transaction_keterangan'] && $trans['name_ppn'] && $trans['name_pph'])
            @if ($currentRow < $totalRowsPerPage - 4)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['transaction_keterangan'] }} {{$yrow}}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['transaction_nominal'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['name_ppn'] }}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['nominal_ppn'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['name_pph'] }}</td>
                <td class="center-text"></td>
                <td class="right-text" style="color: red;">({{ $trans['currency'] }} {{ number_format($trans['nominal_pph'], 0, ',', '.') }})</td>
            </tr>
            @php 
            $currentRow += 3;
            $accumulate += $trans['transaction_nominal'] + $trans['nominal_ppn'] + $trans['nominal_pph'];
            @endphp
            @else
            @while($currentRow < $totalRowsPerPage - 1)
            <tr>
                <td></td>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php $currentRow++; @endphp
            @endwhile
            @php $carryOverRow = $trans; @endphp
            @endif
            @elseif($trans['transaction_keterangan'] && $trans['name_ppn'] && !$trans['name_pph'])
            @if ($currentRow < $totalRowsPerPage - 3)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['transaction_keterangan'] }} {{$yrow}}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['transaction_nominal'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['name_ppn'] }}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['nominal_ppn'], 0, ',', '.') }}</td>
            </tr>
            @php 
            $currentRow += 2;
            $accumulate += $trans['transaction_nominal'] + $trans['nominal_ppn'];
            @endphp
            @else
            @while($currentRow < $totalRowsPerPage - 1)
            <tr>
                <td></td>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php $currentRow++; @endphp
            @endwhile
            @php $carryOverRow = $trans; @endphp
            @endif
            @elseif($trans['transaction_keterangan'] && !$trans['name_ppn'] && $trans['name_pph'])
            @if ($currentRow < $totalRowsPerPage - 3)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['transaction_keterangan'] }} {{$yrow}}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['transaction_nominal'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['name_pph'] }}</td>
                <td class="center-text"></td>
                <td class="right-text" style="color: red;">({{ $trans['currency'] }} {{ number_format($trans['nominal_pph'], 0, ',', '.') }})</td>
            </tr>
            @php 
            $currentRow += 2;
            $accumulate += $trans['transaction_nominal'] + $trans['nominal_pph'];
            @endphp
            @else
            @while($currentRow < $totalRowsPerPage - 1)
            <tr>
                <td></td>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php $currentRow++; @endphp
            @endwhile
            @php $carryOverRow = $trans; @endphp
            @endif
            @elseif($trans['transaction_keterangan'] && !$trans['name_ppn'] && !$trans['name_pph'])
            @if ($currentRow < $totalRowsPerPage - 2)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $trans['transaction_keterangan'] }} {{$yrow}}</td>
                <td class="center-text"></td>
                <td class="right-text">{{ $trans['currency'] }} {{ number_format($trans['transaction_nominal'], 0, ',', '.') }}</td>
            </tr>
            @php 
            $currentRow += 1;
            $accumulate += $trans['transaction_nominal'];
            @endphp
            @else
            @while($currentRow < $totalRowsPerPage - 1)
            <tr>
                <td></td>
                <td style="color: white;">.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php $currentRow++; @endphp
            @endwhile
            @php $carryOverRow = $trans; @endphp
            @endif
            @endif

            @if($currentRow == $totalRowsPerPage - 2 && $index == count($invoiceData) - 1 && !$carryOverRow)
            <tr>
                <td></td>
                <td></td>
                <td>({{$buktiKas->keterangan ?? ''}})</td>
                <td></td>
                <td></td>
            </tr>
            @php $currentRow++; @endphp
            @endif

            @if($currentRow % $totalRowsPerPage == $totalRowsPerPage - 1)
            <tr>
                @php
                $grandTotal += $accumulate;
                @endphp
                <td style="width: 90px"></td>
                <td style="width: 90px"></td>
                <td style="width: 400px"></td>
                <td style="width: 50px" class="center-text"></td>
                <td style="width: 130px" class="right-text">{{$buktiKas->tanda_terima->currency}} {{number_format($grandTotal, 0, ',', '.')}}</td>
            </tr>
        </table>

        <table class="signature">
            <!-- Signature Table -->
            <tr>
                <th colspan="3">Di setujui Oleh :</th>
                <th class="no-border"></th>
                <th colspan="2">Di bukukan Oleh :</th>
                <th class="no-border"></th>
                <th>Dibuat</th>
                <th>Diterima oleh:</th>
            </tr>
            <tr>
                <td class="center-text">Kadept AdmKeu</td>
                <td class="center-text">Kadept Ybs</td>
                <td class="center-text">Direktur</td>
                <td class="no-border"></td>
                <td class="center-text">Ledger</td>
                <td class="center-text">Sub Ledger</td>
                <td class="no-border"></td>
                <td class="no-border-block"></td>
                <td class="no-border-block"></td>
            </tr>
            <tr>
                <td style="height: 60px; width: 100px;"></td>
                <td style="width: 80px;"></td>
                <td style="width: 80px;"></td>
                <td class="no-border" style="width: 30px"></td>
                <td style="height: 60px; width:80px;"></td>
                <td style="height: 60px; width:100px;"></td>
                <td class="no-border" style="width: 30px"></td>
                <td style="height: 60px; width:60px;" class="no-border-top"></td>
                <td style="height: 60px; width:100px;" class="no-border-top"></td>
            </tr>
        </table>
    </div>
        @if($index < count($invoiceData) - 1)
        <div class="page-break"></div>
        @endif
    @php 
    $currentRow = 0;
    $accumulate = 0;
    @endphp
    @endif
    @endforeach

    @if($carryOverRow != null)
        @if (is_array($carryOverRow) && isset($carryOverRow['invoice_keterangan']) && $y != '(' . $carryOverRow['invoice_keterangan'] . ')')
        @php
            $y = '(' . $carryOverRow['invoice_keterangan'] . ')';
            $yrow = '(' . $carryOverRow['invoice_keterangan'] . ')';
        @endphp
        @else
        @php
            $yrow = '';
        @endphp
        @endif
        <div class="page-break"></div>
        <div class="container">
            <table class="xz">
                <!-- Table header code -->
                <tr>
                    <td class="title align-left no-border" style="width: 310px;">PT Indra Eramulti Logam Industri</td>
                    <td class="no-border ver-align align-left" style="width:40px">Nomer</td>
                    <td class="center-text border" style="width: 120px;">{{ $buktiKas->nomer }}</td>
                </tr>
                <tr>
                    <td class="no-border" style="width: 310px;"></td>
                    <td class="no-border ver-align" style="width:40px">Tanggal</td>
                    <td class="center-text border" style="width: 120px;">{{ $buktiKas->tanggal ?? '' }}</td>
                </tr>
                <tr>
                    <td class=" title center-text no-border" colspan="3">BUKTI PENGELUARAN KAS / BANK</td>
                </tr>
            </table>

            <table class="x">
                <!-- Supplier details and other information -->
                <tr>
                    <td class="no-border align-left">Dibayarkan kepada</td>
                    <td class="no-border">: {{$buktiKas->tanda_terima->supplier->name}}</td>
                </tr>
                <tr>
                    <td class="no-border align-left">Kas/Cheque/Bilyet Giro Bank</td>
                    <td class="no-border">: {{$buktiKas->kas}}</td>
                </tr>
                <tr>
                    <td class="no-border align-left">Jumlah USD / Rp</td>
                    <td class="no-border">: {{$buktiKas->tanda_terima->currency}} {{number_format($buktiKas->jumlah, 0, ',', '.')}}</td>
                </tr>
                <tr>
                    <td class="no-border align-left">No. cek</td>
                    <td class="no-border">: {{$buktiKas->no_cek}}</td>
                </tr>
                <tr>
                    <td class="no-border" style="width: 200px;">Tanggal jatuh tempo</td>
                    <td class="no-border">: {{$buktiKas->tanda_terima->tanggal_jatuh_tempo}}</td>
                </tr>
            </table>

            <table class="xy">
                <tr>
                    <th class="center-text">No. Perkiraan</th>
                    <th class="center-text">Nama Perkiraan</th>
                    <th class="center-text">Keterangan</th>
                    <th class="center-text">D/K</th>
                    <th class="center-text">Jumlah</th>
                </tr>
                @endif

                <!-- Handle carry over row from previous page -->
                @if($carryOverRow && $currentRow < $totalRowsPerPage)
                @if($carryOverRow['transaction_keterangan'])
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $carryOverRow['transaction_keterangan'] }}</td>
                    <td class="center-text"></td>
                    <td class="right-text">{{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['transaction_nominal'], 0, ',', '.') }}</td>
                </tr>
                @php
                $currentRow += 1;
                $accumulate += $carryOverRow['transaction_nominal'];
                @endphp
                @endif
                @if ($carryOverRow['name_ppn'])
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $carryOverRow['name_ppn'] }}</td>
                    <td class="center-text"></td>
                    <td class="right-text">{{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['nominal_ppn'], 0, ',', '.') }}</td>
                </tr>
                @php
                $currentRow += 1;
                $accumulate += $carryOverRow['nominal_ppn'];
                @endphp
                @endif
                @if ($carryOverRow['name_pph'])
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $carryOverRow['name_pph'] }}</td>
                    <td class="center-text"></td>
                    <td class="right-text" style="color: red;">({{ $carryOverRow['currency'] }} {{ number_format($carryOverRow['nominal_pph'], 0, ',', '.') }})</td>
                </tr>
                @php
                $currentRow += 1;
                $accumulate += $carryOverRow['nominal_pph'];
                @endphp
                @endif
                @php 
                $carryOverRow = null;
                @endphp
                @endif

                @if($currentRow < $totalRowsPerPage && $index == count($invoiceData) - 1 && !$carryOverRow)
                @while($currentRow < $totalRowsPerPage - 2)
                <tr>
                    <td></td>
                    <td style="color: white;">.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php $currentRow++; @endphp
                @endwhile
                <tr>
                    <td></td>
                    <td></td>
                    <td>({{$buktiKas->keterangan ?? ''}})</td>
                    <td></td>
                    <td></td>
                </tr>
                @php $currentRow++; @endphp
                @endif

                @if($currentRow % $totalRowsPerPage == $totalRowsPerPage - 1 || $index == count($invoiceData) - 1 && !$carryOverRow)
                <tr>
                    @php
                    $grandTotal += $accumulate;
                    @endphp
                    <td style="width: 90px"></td>
                    <td style="width: 90px"></td>
                    <td style="width: 400px"></td>
                    <td style="width: 50px" class="center-text"></td>
                    <td style="width: 130px" class="right-text">{{$buktiKas->tanda_terima->currency}} {{number_format($grandTotal, 0, ',', '.')}}</td>
                </tr>
            </table>

            <table class="signature">
                <!-- Signature Table -->
                <tr>
                    <th colspan="3">Di setujui Oleh :</th>
                    <th class="no-border"></th>
                    <th colspan="2">Di bukukan Oleh :</th>
                    <th class="no-border"></th>
                    <th>Dibuat</th>
                    <th>Diterima oleh:</th>
                </tr>
                <tr>
                    <td class="center-text">Kadept AdmKeu</td>
                    <td class="center-text">Kadept Ybs</td>
                    <td class="center-text">Direktur</td>
                    <td class="no-border"></td>
                    <td class="center-text">Ledger</td>
                    <td class="center-text">Sub Ledger</td>
                    <td class="no-border"></td>
                    <td class="no-border-block"></td>
                    <td class="no-border-block"></td>
                </tr>
                <tr>
                    <td style="height: 60px; width: 100px;"></td>
                    <td style="width: 80px;"></td>
                    <td style="width: 80px;"></td>
                    <td class="no-border" style="width: 30px"></td>
                    <td style="height: 60px; width:80px;"></td>
                    <td style="height: 60px; width:100px;"></td>
                    <td class="no-border" style="width: 30px"></td>
                    <td style="height: 60px; width:60px;" class="no-border-top"></td>
                    <td style="height: 60px; width:100px;" class="no-border-top"></td>
                </tr>
            </table>
        </div>
    @endif
</body>

</html>