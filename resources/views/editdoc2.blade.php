<x-layout>
    @section('title', 'Edit Bukti Pengeluaran Kas')
    <style>
        .required {
            color: red;
        }
    </style>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full">
        @if (session('success'))
        <div class="alert alert-success">
        <script>
            alert("Bukti kas berhasil dibuat");
        </script>
        </div>
        @endif
        <div id="loading-container" class="hidden fixed inset-0 flex items-center justify-center bg-transparent">
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        @php
        $nomer = $buktiKasRecords->nomer; // Example value
        $parts = explode('/', $nomer);

        $kode = $parts[0];
        $nomor = $parts[1];
        $bulan = $parts[2];
        $tahun = $parts[3];
        @endphp
        <div class="py-4 px-8 mx-auto max-w-7xl">
            <form id="my-form" action="/dashboard/edit/bukti-kas/{{$buktiKasRecords->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="grid gap-x-8 gap-y-4 mb-6 lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1">
                    <div class="col-span-1">
                        <label for="nomer-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer <span class="required">*</span></label>
                        <div class="flex space-x-2">
                            <select id="dropdown-kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="RMK" {{ $kode == 'RMK' ? 'selected' : '' }}>RMK</option>
                                <option value="DMK" {{ $kode == 'DMK' ? 'selected' : '' }}>DMK</option>
                            </select>

                            <select id="dropdown-bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="I" {{ $bulan == 'I' ? 'selected' : '' }}>I</option>
                                <option value="II" {{ $bulan == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ $bulan == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ $bulan == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V" {{ $bulan == 'V' ? 'selected' : '' }}>V</option>
                                <option value="VI" {{ $bulan == 'VI' ? 'selected' : '' }}>VI</option>
                                <option value="VII" {{ $bulan == 'VII' ? 'selected' : '' }}>VII</option>
                                <option value="VIII" {{ $bulan == 'VIII' ? 'selected' : '' }}>VIII</option>
                                <option value="IX" {{ $bulan == 'IX' ? 'selected' : '' }}>IX</option>
                                <option value="X" {{ $bulan == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ $bulan == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ $bulan == 'XII' ? 'selected' : '' }}>XII</option>
                            </select>

                            <select id="dropdown-tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @php
                                $startYear = date('Y');
                                for ($i = 0; $i < 8; $i++) {
                                    $year=$startYear + $i;
                                    echo "<option value=\" $year\"" . ($year==$tahun ? ' selected' : '' ) . ">$year</option>" ;
                                    }
                                    @endphp
                                    </select>
                        </div>
                        <input type="hidden" id="nomer" name="nomer" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div class="col-span-1">
                        <label for="dropdown-no-tanda-terima" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Tanda Terima <span class="required">*</span></label>
                        <div class="relative">
                            <input type="text" id="dropdown-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukan nomor tanda terima" autocomplete="off" value="{{$buktiKasRecords->tanda_terima->increment_id}}" required>
                            <div id="dropdown-options" class="absolute left-0 right-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white z-10 hidden max-h-60 overflow-auto">
                                @foreach($tandaTerimas as $tandaTerima)
                                <div class="option p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" data-value="{{ $tandaTerima->increment_id }}">{{ $tandaTerima->increment_id }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label for="input-part3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibayarkan kepada <span class="required">*</span></label>
                        <input type="text" id="input-supplier" name="supplier-name" value="{{$buktiKasRecords->tanda_terima->supplier->name}}" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Automatic Input" readonly required>
                        <input type="hidden" id="input-no-tanda-terima-hidden" name="tanda_terima_id_hidden" value="{{$buktiKasRecords->tanda_terima_id}}" readonly>
                        <input type="hidden" id="ppnData" value="{{ json_encode($ppn) }}">
                        <input type="hidden" id="pphData" value="{{ json_encode($pph) }}">
                        <input type="hidden" id="bukti_data" name="bukti_data" value="">
                        <input type="hidden" id="nomorPart" value={{$nomor}}>
                    </div>
                    <div class="col-span-1">
                        <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal jatuh tempo <span class="required">*</span></label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide-x" datepicker-format="dd-mm-yyyy" datepicker-autohide type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 cursor-not-allowed focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Automatic input" value="{{$buktiKasRecords->tanda_terima->tanggal_jatuh_tempo}}" readonly required>
                        </div>
                    </div>
                    <div class="col-start-1">
                        <label for="input-part4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kas/Cheque/Bilyet Giro Bank <span class="required">*</span></label>
                        <input type="text" id="input-bank" name="kas" value="Mandiri" class=" bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    <div class="col-span-1">
                        <label for="berita_transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berita Transaksi <span class="required">*</span></label>
                        <input type="text" id="berita_transaksi" name="berita_transaksi" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan berita" value="{{ $buktiKasRecords->berita_transaksi }}" required>
                    </div>
                    <div class="col-span-1">
                        <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. cek</label>
                        <input type="number" id="number-input" name="no_cek" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan nomor" value="{{$buktiKasRecords->no_cek}}">
                    </div>
                    <div class="col-span-1">
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan keterangan" value="{{ $buktiKasRecords->keterangan }}">
                    </div>
                    <div class="col-span-4">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="buktiTable">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 border-gray-200 dark:border-gray-700">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3 border-gray-200 dark:border-gray-700">
                                            Keterangan
                                        </th>
                                        <th scope="col" class="px-6 py-3 border-gray-200 dark:border-gray-700">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="text-center w-1/7 px-6 py-3 border-gray-200 dark:border-gray-700">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr class="font-semibold text-gray-900 dark:text-white">
                                        <th scope="row" class="px-6 py-3 text-base w-1/7">Total</th>
                                        <td class=" w-3/7"></td>
                                        <td class="w-2/7"></td>
                                        <td class="px-6 py-3 text-right w-1/7">
                                            0
                                        </td>
                                    </tr>
                                </tfoot>
                                <input type="hidden" name="jumlah" id="total-amount">
                            </table>
                        </div>
                    </div>
                    <div class="col-start-4 flex justify-evenly pt-4">
                        <button id="submit-btn" type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buktiTable = document.getElementById('buktiTable').getElementsByTagName('tbody')[0];
            let no = 1;
            bukti = [];
            const tandaTerimaInput = document.getElementById('dropdown-no-tanda-terima');
            const tandaTerimaHiddenInput = document.getElementById('input-no-tanda-terima-hidden');
            const supplier = document.getElementById('input-supplier');
            // let original = null;

            document.querySelectorAll('#dropdown-kode, #dropdown-bulan, #dropdown-tahun').forEach(input => {
                input.addEventListener('input', updateNomer);
            });

            function updateNomer() {
                const nomer = document.getElementById('nomer')
                const part1 = document.getElementById('dropdown-kode').value;
                const part2 = document.getElementById('dropdown-bulan').value;
                const part3 = document.getElementById('dropdown-tahun').value;
                const partNomor = document.getElementById('nomorPart').value;
                console.log(partNomor);
                if (partNomor === '' || partNomor.replace(/\u00A0/g, '').trim() === '') {
                    nomer.value = `${part1}/\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0/${part2}/${part3}`;
                } else {
                    nomer.value = `${part1}/${partNomor}/${part2}/${part3}`;
                }
                console.log(nomer.value);
            }

            const searchInput = document.getElementById('dropdown-search');
            const optionsContainer = document.getElementById('dropdown-options');
            const options = optionsContainer.getElementsByClassName('option');
            let isOptionClicked = false;

            searchInput.addEventListener('focus', function() {
                optionsContainer.classList.remove('hidden');
                filterOptions();
            });

            searchInput.addEventListener('input', function() {
                filterOptions();
            });

            searchInput.addEventListener('blur', function(event) {
                if (isOptionClicked) {
                    event.preventDefault(); // Prevent blur if an option was clicked
                    isOptionClicked = false; // Reset the flag
                    return;
                }
                optionsContainer.classList.add('hidden');
                updateSupplierInfo(searchInput.value);
            });

            optionsContainer.addEventListener('mousedown', function(event) {
                if (event.target.classList.contains('option')) {
                    isOptionClicked = true;
                    searchInput.value = event.target.textContent;
                    updateSupplierInfo(searchInput.value);
                    optionsContainer.classList.add('hidden');
                    searchInput.setCustomValidity('');
                }
            });

            function filterOptions() {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < options.length; i++) {
                    const option = options[i];
                    const text = option.textContent.toLowerCase();

                    if (text.includes(filter)) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            }

            function updateSupplierInfo(id) {
                const tandaTerimaId = id;
                const buktiKasId = "{{ $buktiKasRecords->id }}";
                const loadingContainer = document.getElementById('loading-container');

                // Show the loading animation
                loadingContainer.classList.remove('hidden');

                fetch(`/get-supplier-info/${tandaTerimaId}/${buktiKasId}?`) // Ensure the correct parameter name
                    .then(response => response.json())
                    .then(data => {
                        if (data.supplier_name) {
                            document.getElementById('input-no-tanda-terima-hidden').value = data.tanda_terima_id;
                            supplier.value = data.supplier_name;

                            // Update the datepicker field
                            document.getElementById('datepicker-autohide-x').value = data.tanggal_jatuh_tempo;
                            let currency = data.currency
                            console.log(bukti);
                            bukti = data.invoiceData.map(item => ({
                                invoiceKeterangan: item.invoice_keterangan,
                                transaction_id: item.transaction_id,
                                transactionKeterangan: item.transaction_keterangan,
                                nominalValue: item.transaction_nominal,
                                selectedCurrency: item.currency,
                                ppnid: item.id_ppn || null,
                                ppnNominal: item.nominal_ppn || null,
                                pphid: item.id_pph || null,
                                pphNominal: item.nominal_pph || null,
                                nominalSetelah: item.nomila_setelah || null,
                                ppnName: item.ppn_name || null,
                                pphName: item.pph_name || null,
                                ppnpercentage: item.ppn_percentage || null,
                                pphpercentage: item.pph_percentage || null
                            }));
                            console.log(bukti);
                            renderTable();
                        } else {
                            console.log(data);
                            alert('Tanda Terima not found');
                            document.getElementById('datepicker-autohide-x').value = '';
                            document.getElementById('input-no-tanda-terima-hidden').value = '';
                            supplier.value = '';
                            buktiTable.innerHTML = '';
                            updateTotal();
                        }
                    })
                    .catch(error => {
                        alert('Tanda Terima not found');
                        document.getElementById('datepicker-autohide-x').value = '';
                        document.getElementById('input-no-tanda-terima-hidden').value = '';
                        supplier.value = '';
                        buktiTable.innerHTML = '';
                        updateTotal();
                    }).finally(() => {
                        loadingContainer.classList.add('hidden');
                        // Hide the loading animation
                    });
            }

            // Function to format currency
            function formatCurrency(value, currency) {
                return `${currency} ${new Intl.NumberFormat('en-US').format(value)}`;
            }

            function updateTotal() {
                const rows = buktiTable.getElementsByTagName('tr');
                let total = 0;
                let currency = '';

                // Iterate through table rows to calculate total and determine currency
                for (let i = 0; i < rows.length; i++) {
                    const cellAmount = rows[i].cells[2].textContent.trim();
                    const parts = cellAmount.split(' ');
                    if (parts.length === 2) {
                        // Replace commas with nothing and periods with commas for numeric value parsing
                        const numericValue = parseFloat(parts[1].replace(/,/g, '').replace(/\./g, '.'));
                        if (!isNaN(numericValue)) {
                            total += numericValue;
                            currency = parts[0];
                        }
                    }
                }

                // Ensure the currency is consistent
                const totalCell = document.querySelector('#buktiTable tfoot tr td:last-child');
                totalCell.textContent = formatCurrency(total, currency);
                document.getElementById('total-amount').value = total;
            }

            function updateRowNumbers() {
                const rows = buktiTable.getElementsByTagName('tr');
                for (let i = 0; i < rows.length; i++) {
                    const cell = rows[i].getElementsByTagName('td')[0];
                    cell.textContent = i + 1;
                }
            }

            function renderTable() {
                // Clear existing rows in the table
                buktiTable.innerHTML = ''; // Clear all rows except for header

                // Keep track of the row index
                let rowIndex = 1;

                // Iterate through the bukti array
                bukti.forEach((item, index) => {
                    const isFirstTransaction = index === 0 || bukti[index - 1].invoiceKeterangan !== item.invoiceKeterangan;

                    // Add a new row for each transaction
                    const newRow = buktiTable.insertRow();
                    newRow.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";
                    newRow.dataset.buktiIndex = index;

                    if (isFirstTransaction) {
                        const cellNo = newRow.insertCell(0);
                        cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
                        cellNo.textContent = rowIndex++;

                        const cellKeterangan = newRow.insertCell(1);
                        cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                        cellKeterangan.textContent = `${item.transactionKeterangan} (${item.invoiceKeterangan})`;

                        const cellAmount = newRow.insertCell(2);
                        cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
                        cellAmount.textContent = formatCurrency(item.nominalValue, item.selectedCurrency);
                    } else {
                        // Handle subsequent transactions without index or invoice keterangan
                        const cellNo = newRow.insertCell(0);
                        cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
                        cellNo.textContent = '';

                        const cellKeterangan = newRow.insertCell(1);
                        cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                        cellKeterangan.textContent = item.transactionKeterangan;

                        const cellAmount = newRow.insertCell(2);
                        cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
                        cellAmount.textContent = formatCurrency(item.nominalValue, item.selectedCurrency);
                    }

                    // Add "Add PPn" and "Add PPh" buttons in the "aksi" column
                    const cellAksi = newRow.insertCell(3);
                    cellAksi.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-center";

                    const addPPnButton = document.createElement('button');
                    addPPnButton.textContent = 'Add PPn';
                    addPPnButton.className = 'ppnButton px-2 py-1 text-blue-500 text-xs rounded';
                    addPPnButton.type = 'button';
                    addPPnButton.onclick = () => {
                        addTaxRow('PPn', item.nominalValue, item.selectedCurrency, newRow);
                        addPPnButton.style.display = 'none';
                        updateTotal();
                    };

                    const addPPhButton = document.createElement('button');
                    addPPhButton.textContent = 'Add PPh';
                    addPPhButton.className = 'pphButton px-2 py-1 text-blue-500 text-xs rounded ml-2';
                    addPPhButton.type = 'button';
                    addPPhButton.onclick = () => {
                        addTaxRow('PPh', item.nominalValue, item.selectedCurrency, newRow);
                        addPPhButton.style.display = 'none';
                        updateTotal();
                    };

                    cellAksi.appendChild(addPPnButton);
                    cellAksi.appendChild(addPPhButton);

                    // If the PPn or PPh has already been added, hide the corresponding button
                    if (item.ppnid) {
                        addPPnButton.style.display = 'none';
                        addTaxRow('PPn', item.nominalValue, item.selectedCurrency, newRow, item.ppnid, item.ppnNominal, item.ppnName, item.ppnpercentage);
                    }
                    if (item.pphid) {
                        addPPhButton.style.display = 'none';
                        addTaxRow('PPh', item.nominalValue, item.selectedCurrency, newRow, item.pphid, item.pphNominal, item.pphName, item.pphpercentage);
                    }
                });
                // Update the row numbers and total after rendering
                updateTotal();
            }

            function addTaxRow(type, baseAmount, currency, referenceRow, existingTaxId = null, existingTaxAmount = null, existingName = null, existingPercentage = null) {
                // Fetch all tax rates from your data source
                const taxRates = getTaxRates(type);

                // Create a new row
                const newRow = buktiTable.insertRow(referenceRow.rowIndex);
                newRow.className = "bg-gray-100 border-b dark:bg-gray-900 dark:border-gray-700";

                // Empty cell for index
                const cellNo = newRow.insertCell(0);
                cellNo.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";

                // Cell for tax description with dropdown
                const cellKeterangan = newRow.insertCell(1);
                cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";

                const select = document.createElement('select');
                select.className = 'form-select';

                // Create dropdown options for tax rates
                taxRates.forEach(rate => {
                    const option = document.createElement('option');
                    option.value = rate.id; // Assuming each rate has a unique ID
                    option.textContent = `${rate.name} (${rate.percentage}%)`; // Adjust according to your data
                    if (existingTaxId && existingTaxId == rate.id) {
                        option.selected = true; // Pre-select the existing tax rate
                    }
                    select.appendChild(option);
                });

                if (existingName && existingPercentage) {
                    const existingTax = taxRates.find(tax =>
                        tax.name === existingName && tax.percentage === existingPercentage
                    );

                    if (!existingTax) {
                        const customOption = document.createElement('option');
                        customOption.value = ''; // No value, just for display
                        customOption.textContent = `${existingName} (${existingPercentage}%)`;
                        customOption.selected = true; // Select this custom option
                        customOption.disabled = true; // Disable this option to prevent selection
                        select.appendChild(customOption);
                    }
                }

                // Cell for tax amount
                const cellAmount = newRow.insertCell(2);
                cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
                cellAmount.textContent = formatCurrency(existingTaxAmount || 0, currency);

                // Update tax amount when a rate is selected
                select.addEventListener('change', (event) => {
                    const selectedRateId = event.target.value;
                    const selectedRate = taxRates.find(rate => rate.id === selectedRateId);
                    if (selectedRate) {
                        const taxAmount = calculateTaxAmount(baseAmount, selectedRate.percentage, type);
                        cellAmount.textContent = formatCurrency(taxAmount, currency);

                        const buktiIndex = referenceRow.dataset.buktiIndex;
                        if (type === 'PPn') {
                            bukti[buktiIndex].ppnid = selectedRate.id;
                            bukti[buktiIndex].ppnNominal = taxAmount;
                        } else if (type === 'PPh') {
                            bukti[buktiIndex].pphid = selectedRate.id;
                            bukti[buktiIndex].pphNominal = taxAmount;
                        }
                        console.log(bukti);
                        updateTotal();
                    }
                    const customOption = select.querySelector('option[value=""]');
                    if (customOption) {
                        select.removeChild(customOption); // Remove the custom option after selecting a valid tax rate
                    }
                });

                cellKeterangan.appendChild(select);

                // Cell for actions (delete button)
                const cellAksi = newRow.insertCell(3);
                cellAksi.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-center";

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'px-4 py-2 bg-red-500 text-white rounded';
                deleteButton.onclick = () => {
                    newRow.remove();
                    const buktiIndex = referenceRow.dataset.buktiIndex;
                    if (type === 'PPn') {
                        bukti[buktiIndex].ppnid = null;
                        bukti[buktiIndex].ppnNominal = null;
                        referenceRow.querySelector('button.ppnButton').style.display = 'inline-block';
                    } else if (type === 'PPh') {
                        bukti[buktiIndex].pphid = null;
                        bukti[buktiIndex].pphNominal = null;
                        referenceRow.querySelector('button.pphButton').style.display = 'inline-block';
                    }
                    console.log(bukti)
                    updateTotal();
                };

                cellAksi.appendChild(deleteButton);

                // If there's an existing tax, update the bukti object
                if (existingTaxId) {
                    const buktiIndex = referenceRow.dataset.buktiIndex;
                    if (type === 'PPn') {
                        bukti[buktiIndex].ppnid = existingTaxId;
                        bukti[buktiIndex].ppnNominal = existingTaxAmount;
                    } else if (type === 'PPh') {
                        bukti[buktiIndex].pphid = existingTaxId;
                        bukti[buktiIndex].pphNominal = existingTaxAmount;
                    }
                    console.log(bukti);
                } else {
                    const selectedRate = taxRates.find(rate => rate.id);
                    if (selectedRate) {
                        const taxAmount = calculateTaxAmount(baseAmount, selectedRate.percentage, type);
                        cellAmount.textContent = formatCurrency(taxAmount, currency);
                        const buktiIndex = referenceRow.dataset.buktiIndex;
                        if (type === 'PPn') {
                            console.log(buktiIndex);
                            bukti[buktiIndex].ppnid = selectedRate.id;
                            bukti[buktiIndex].ppnNominal = taxAmount;
                        } else if (type === 'PPh') {
                            bukti[buktiIndex].pphid = selectedRate.id;
                            bukti[buktiIndex].pphNominal = taxAmount;
                        }
                        console.log(bukti);
                    }
                }

            }

            function getTaxRates(type) {
                // Get tax data from hidden inputs
                const ppnData = JSON.parse(document.getElementById('ppnData').value);
                console.log(ppnData);
                const pphData = JSON.parse(document.getElementById('pphData').value);

                if (type === 'PPn') {
                    return ppnData;
                } else if (type === 'PPh') {
                    return pphData;
                }
                return [];
            }

            function calculateTaxAmount(baseAmount, rate, type) {
                let taxAmount;
                if (type === 'PPn') {
                    taxAmount = baseAmount * (rate / 100);
                } else if (type === 'PPh') {
                    taxAmount = -(baseAmount * (rate / 100));
                }
                taxAmount = Math.round(taxAmount);
                return taxAmount;
            }

            document.getElementById('my-form').addEventListener('submit', function(e) {
                const confirmSubmit = confirm('Are you sure you want to submit the form?');
                if (!confirmSubmit) {
                    e.preventDefault(); // Prevent form submission if user cancels
                    return;
                }
                const buktiJson = JSON.stringify(bukti);
                document.getElementById('bukti_data').value = buktiJson;
            });

            function preventEnterKey(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission
                }
            }

            // Get all input fields within the form
            const inputs = document.querySelectorAll('#my-form input, #my-form textarea, #my-form select');

            // Attach the event listener to each input field
            inputs.forEach(input => {
                input.addEventListener('keydown', preventEnterKey);
            });

            updateNomer();
            updateSupplierInfo(searchInput.value);
        });
    </script>
</x-layout>