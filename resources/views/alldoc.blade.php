<x-layout>
    @section('title', 'All Documents')
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full min-h-screen flex flex-col">
        <!-- Loading Animation -->
        <div id="loading-container" class="hidden fixed inset-0 flex items-center justify-center bg-transparent">
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <nav class="bg-gray-800 border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center">
                <!-- Left section: Links -->
                <div class="flex justify-start items-center space-x-4 lg:space-x-8">
                    <a href="#" class="text-gray-300 hover:text-white" id="tanda-terima-link">Tanda Terima</a>
                    <a href="#" class="text-gray-300 hover:text-white" id="bukti-kas-keluar-link">Bukti Kas Keluar</a>
                </div>

                <!-- Middle section: Supplier and Dates -->
                <div class="flex flex-wrap justify-center items-center space-x-2 lg:space-x-4 mt-2 lg:mt-0">
                    <form id="filter-form" action="#" method="GET" class="flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto">
                        <div class="relative mt-1 lg:mt-0">
                            <label for="supplier" class="sr-only">Supplier</label>
                            <select id="supplier" name="supplier" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="" selected>Select supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="relative mt-1 lg:mt-0">
                            <label for="start-date" class="sr-only">Start Date</label>
                            <input type="date" id="start-date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="relative mt-1 lg:mt-0">
                            <label for="end-date" class="sr-only">End Date</label>
                            <input type="date" id="end-date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                    </form>
                </div>

                <!-- Right section: Search -->
                <div class="flex justify-end items-center mt-2 lg:mt-0">
                    <form action="#" method="GET" class="lg:w-96">
                        <label for="topbar-search" class="sr-only">Search</label>
                        <div class="relative mt-1 lg:mt-0">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
                        </div>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container flex-grow overflow-auto">
            <div id="tanda-terima-table" class="bg-white shadow-md rounded-lg hidden">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="sticky top-0 bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Nomor Tanda Terima</th>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Supplier</th>
                            <th class="py-2 px-4 border-b text-center">Faktur Pajak</th>
                            <th class="py-2 px-4 border-b text-center">PO</th>
                            <th class="py-2 px-4 border-b text-center">BPB</th>
                            <th class="py-2 px-4 border-b text-center">Surat Jalan</th>
                            <th class="py-2 px-4 border-b">Tanggal Jatuh Tempo</th>
                            <th class="py-2 px-4 border-b">Keterangan</th>
                            <th class="py-2 px-4 border-b">Pembuat</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tandaTerimaRecords as $tt)
                        <tr class="border border-b">
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->index + 1 }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $tt->increment_id }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 tanggal">{{ $tt->tanggal }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 supplier">{{ $tt->supplier->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500 pajak">
                                {!! $tt->pajak == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500 po">
                                {!! $tt->po == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500 bpb">
                                {!! $tt->bpb == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500 surat-jalan">
                                {!! $tt->surat_jalan == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 jatuh-tempo">{{ $tt->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 text-sm text-gray-500 break-words keterangan">{{ $tt->keterangan ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 dibuat-oleh">{{ $tt->user->name ?? 'N/A' }}</td>
                            @if (Auth::check() && Auth::user()->role == 'admin')
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center">
                                <div class="flex justify-center items-center space-x-4">
                                    <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $tt->id }}" data-table="tanda-terima">View Details</a>
                                    <a href="/dashboard/edit/tanda-terima/{{$tt->id}}" class="text-blue-500 hover:text-blue-700 edit" data-id="{{ $tt->id }}" data-table="tanda-terima">Edit</a>
                                    <form id="delete-form" action="/tanda-terima/{{$tt->id}}/delete" method="POST" class="inline-block m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-blue-500 hover:text-blue-700 delete-link p-0 m-0 border-0 bg-transparent cursor-pointer">Delete</button>
                                    </form>
                                    <a href="/dashboard/print/tanda-terima/{{$tt->id}}" class="text-blue-500 hover:text-blue-700 print" target="_blank" rel="noopener noreferrer">Print</a>
                                </div>
                            </td>
                            @else
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center">
                                <a href="#" class="text-blue-500 mr-4 hover:text-blue-700 view-details" data-id="{{ $tt->id }}" data-table="tanda-terima">View Details</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="bukti-kas-keluar-table" class="bg-white shadow-md rounded-lg hidden">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="sticky top-0 bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Nomor Bukti Kas Keluar</th>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Dibayarkan kepada</th>
                            <th class="py-2 px-4 border-b text-center">Kas</th>
                            <th class="py-2 px-4 border-b text-center">Jumlah</th>
                            <th class="py-2 px-4 border-b text-center">No Cek</th>
                            <th class="py-2 px-4 border-b">Tanggal Jatuh Tempo</th>
                            <th class="py-2 px-4 border-b">Berita Transaksi</th>
                            <th class="py-2 px-4 border-b">Pembuat</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buktiKasRecords as $bk)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $loop->index + 1 }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center nomer">{{ $bk->nomer }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center tanggal">{{ $bk->tanggal ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center dibayarkan-kepada">{{ $bk->tanda_terima->supplier->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center kas">{{ $bk->kas }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center jumlah"> {{$bk->tanda_terima->currency }} {{ number_format($bk->jumlah) }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center no-cek">{{ $bk->no_cek }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center jatuh-tempo">{{ $bk->tanda_terima->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center berita-transaksi">{{ $bk->berita_transaksi}}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center dibuat-oleh">{{ $bk->user->name }}</td>
                            @if (Auth::check() && Auth::user()->role == 'admin')
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center inline-flex">
                                <div class="flex justify-center items-center space-x-4">
                                    <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $bk->id }}" data-table="bukti-kas">View Details</a>
                                    <a href="/dashboard/edit/bukti-kas/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 edit" data-id="{{ $bk->id }}" data-table="bukti-kas">Edit</a>
                                    <form id="delete-form-bk" action="/bukti-kas/{{$bk->id}}/delete" method="POST" class="inline-block m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-blue-500 hover:text-blue-700 delete-link p-0 m-0 border-0 bg-transparent cursor-pointer">Delete</button>
                                    </form>
                                    <a href="/dashboard/print/bukti-kas/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 print" target="_blank" rel="noopener noreferrer">Print</a>
                                    <a href="/dashboard/print/mandiri/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 print" target="_blank" rel="noopener noreferrer">Print Mandiri</a>
                                </div>
                            </td>
                            @else
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center">
                                <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $bk->id }}" data-table="bukti-kas">View Details</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal -->
            <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

            <div id="detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-hidden">
                        <div class="p-6 max-h-[80vh] overflow-y-auto">
                            <button id="close-modal" class="absolute top-4 right-4 flex w-8 h-8 ms-auto inline-flex justify-center items-center text-gray-600 hover:text-gray-900">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                            <h2 class="text-2xl font-bold mb-4">Detail Bukti Kas</h2>
                            <div id="details-content">
                                <!-- Details will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function filterTableRows() {
            console.log('Filtering...');
            const selectedSupplier = document.getElementById('supplier').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            console.log('Selected Supplier:', selectedSupplier);
            console.log('Start Date:', startDate);
            console.log('End Date:', endDate);

            const tables = ['tanda-terima-table', 'bukti-kas-keluar-table'];

            tables.forEach(tableId => {
                const rows = document.querySelectorAll(`#${tableId} tbody tr`);
                let visibleRows = 0;

                rows.forEach(row => {
                    const supplierCell = row.querySelector('td:nth-child(4)');
                    const dateCell = row.querySelector('td:nth-child(3)');

                    if (!supplierCell || !dateCell) return;

                    const supplierName = supplierCell.textContent.trim();
                    const rowDateStr = dateCell.textContent.trim();

                    let showRow = true;

                    // Check supplier
                    if (selectedSupplier && selectedSupplier !== "") {
                        showRow = supplierName === selectedSupplier;
                    }

                    // Check date range
                    if (showRow && (startDate || endDate)) {
                        const rowDate = parseDate(rowDateStr);

                        if (startDate && rowDate < parseDate(startDate)) {
                            showRow = false;
                        }
                        if (endDate && rowDate > parseDate(endDate)) {
                            showRow = false;
                        }
                    }

                    row.style.display = showRow ? '' : 'none';
                    if (showRow) visibleRows++;
                });

                console.log(`Visible rows in ${tableId}: ${visibleRows}`);
            });
        }

        function filterTableRows() {
            console.log('Filtering...');
            const selectedSupplier = document.getElementById('supplier').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            console.log('Selected Supplier:', selectedSupplier);
            console.log('Start Date:', startDate);
            console.log('End Date:', endDate);

            const tables = ['tanda-terima-table', 'bukti-kas-keluar-table'];

            tables.forEach(tableId => {
                const rows = document.querySelectorAll(`#${tableId} tbody tr`);
                let visibleRows = 0;

                rows.forEach(row => {
                    const supplierCell = row.querySelector('td:nth-child(4)');
                    const dateCell = row.querySelector('td:nth-child(3)');

                    if (!supplierCell || !dateCell) return;

                    const supplierName = supplierCell.textContent.trim();
                    const rowDateStr = dateCell.textContent.trim();

                    let showRow = true;

                    // Check supplier
                    if (selectedSupplier && selectedSupplier !== "") {
                        showRow = supplierName === selectedSupplier;
                    }

                    // Check date range
                    if (showRow && (startDate || endDate)) {
                        const rowDate = parseDate(rowDateStr);

                        if (startDate && rowDate < parseDate(startDate)) {
                            showRow = false;
                        }
                        if (endDate && rowDate > parseDate(endDate)) {
                            showRow = false;
                        }
                    }

                    row.style.display = showRow ? '' : 'none';
                    if (showRow) visibleRows++;
                });

                console.log(`Visible rows in ${tableId}: ${visibleRows}`);
            });
        }

        function switchTable(showTableId, hideTableId, activeLinkId, inactiveLinkId, newUrl) {
            document.getElementById(showTableId).classList.remove('hidden');
            document.getElementById(hideTableId).classList.add('hidden');
            document.getElementById(activeLinkId).classList.add('text-white');
            document.getElementById(activeLinkId).classList.remove('text-gray-300');
            document.getElementById(inactiveLinkId).classList.remove('text-white');
            document.getElementById(inactiveLinkId).classList.add('text-gray-300');
            window.history.pushState(null, null, newUrl);
        }

        document.getElementById('tanda-terima-link').addEventListener('click', function(event) {
            event.preventDefault();
            switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link', '/dashboard/all/tanda-terima');
        });

        document.getElementById('bukti-kas-keluar-link').addEventListener('click', function(event) {
            event.preventDefault();
            switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link', '/dashboard/all/bukti-kas');
        });

        const detailModal = document.getElementById('detail-modal');
        const detailsContent = document.getElementById('details-content');
        const closeModalButton = document.getElementById('close-modal');
        const formatter = new Intl.NumberFormat('en-US');

        document.querySelectorAll('.view-details').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('modal-overlay').classList.remove('hidden');

                const typeId = this.getAttribute('data-id');
                const tableType = this.getAttribute('data-table');
                const loadingContainer = document.getElementById('loading-container');

                // Show the loading animation
                loadingContainer.classList.remove('hidden');

                if (tableType == "bukti-kas") {
                    // Use data from the clicked row
                    const row = this.closest('tr');
                    const nomer = row.querySelector('.nomer').textContent;
                    const tanggal = row.querySelector('.tanggal').textContent;
                    const dibayarkanKepada = row.querySelector('.dibayarkan-kepada').textContent;
                    const dibayarkan = row.querySelector('.kas').textContent;
                    const jumlah = row.querySelector('.jumlah').textContent;
                    const noCek = row.querySelector('.no-cek').textContent;
                    const tanggalJatuhTempo = row.querySelector('.jatuh-tempo').textContent;
                    const beritaTransaksi = row.querySelector('.berita-transaksi').textContent;
                    const dibuatOleh = row.querySelector('.dibuat-oleh').textContent;

                    fetch(`/bukti-kas/${typeId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            const {
                                ket,
                                currency
                            } = data;
                            const formatter = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            detailsContent.innerHTML = `
                        <div class="mb-4"><strong>Nomer:</strong> ${nomer}</div>
                        <div class="mb-4"><strong>Tanggal:</strong> ${tanggal || 'N/A'}</div>
                        <div class="mb-4"><strong>Dibayarkan kepada:</strong> ${dibayarkanKepada || 'N/A'}</div>
                        <div class="mb-4"><strong>Kas/Cheque/Bilyet Giro Bank:</strong> ${dibayarkan || 'N/A'}</div>
                        <div class="mb-4"><strong>Jumlah:</strong> ${jumlah || 'N/A'}</div>
                        <div class="mb-4"><strong>No. Cek:</strong> ${noCek || 'N/A'}</div>
                        <div class="mb-4"><strong>Tanggal Jatuh Tempo:</strong> ${tanggalJatuhTempo || 'N/A'}</div>
                        <div class="mb-4"><strong>Berita Transaksi:</strong> ${beritaTransaksi || 'N/A'}</div>
                        <div class="mb-4"><strong>Dibuat oleh:</strong> ${dibuatOleh || 'N/A'}</div>
                        <div class="mb-4"><strong>Keterangan Bukti Kas:</strong></div>
                        <table class="w-full bg-white rtl:text-right border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr class="text-gray-700">
                                    <th scope="col" class="py-2 px-4 border-b w-1/6 text-start">No</th>
                                    <th scope="col" class="py-2 px-4 border-b w-1/2 text-start">Keterangan</th>
                                    <th scope="col" class="py-2 px-4 border-b w-1/6 text-start">D/K</th>
                                    <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${ket.map((kbk, index) => `
                                    <tr>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${index + 1}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/2">${kbk.keterangan}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${kbk.dk}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${currency} ${formatter.format(kbk.jumlah)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                            // Show the modal
                            detailModal.classList.remove('hidden');
                        })
                        .catch(error => console.error('Error fetching KeteranganBuktiKas details:', error))
                        .finally(() => {
                            // Hide the loading animation
                            loadingContainer.classList.add('hidden');
                        });

                } else if (tableType == "tanda-terima") {
                    const row = this.closest('tr');
                    const tanggal = row.querySelector('.tanggal').textContent;
                    const supplier = row.querySelector('.supplier').textContent;
                    const fakturPajak = row.querySelector('.pajak').textContent;
                    const po = row.querySelector('.po').textContent;
                    const bpb = row.querySelector('.bpb').textContent;
                    const suratJalan = row.querySelector('.surat-jalan').textContent;
                    const tanggalJatuhTempo = row.querySelector('.jatuh-tempo').textContent;
                    const keterangan = row.querySelector('.keterangan').textContent;
                    const pembuat = row.querySelector('.dibuat-oleh').textContent;

                    fetch(`/tanda-terima/${typeId}/invoices`)
                        .then(response => response.json())
                        .then(data => {
                            const {
                                invoices,
                                currency
                            } = data;
                            const formatter = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });

                            detailsContent.innerHTML = `
                        <div class="mb-4"><strong>Tanggal:</strong> ${tanggal || 'N/A'}</div>
                        <div class="mb-4"><strong>Supplier:</strong> ${supplier || 'N/A'}</div>
                        <div class="mb-4"><strong>Faktur Pajak:</strong> ${fakturPajak}</div>
                        <div class="mb-4"><strong>PO:</strong> ${po}</div>
                        <div class="mb-4"><strong>BPB:</strong> ${bpb}</div>
                        <div class="mb-4"><strong>Surat Jalan:</strong> ${suratJalan}</div>
                        <div class="mb-4"><strong>Tanggal Jatuh Tempo:</strong> ${tanggalJatuhTempo}</div>
                        <div class="mb-4"><strong>Keterangan:</strong> ${keterangan}</div>
                        <div class="mb-4"><strong>Dibuat oleh:</strong> ${pembuat}</div>
                        <div class="mb-4"><strong>Invoices:</strong></div>
                        <table class="w-full bg-white rtl:text-right border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr class="text-gray-700">
                                    <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">No</th>
                                    <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">Invoice</th>
                                    <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${invoices.map((kbk, index) => `
                                    <tr>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${index + 1}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${kbk.nomor}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${currency} ${formatter.format(kbk.nominal)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        `;

                            // Show the modal
                            detailModal.classList.remove('hidden');
                        })
                        .catch(error => console.error('Error fetching tandaTerimaInvoices details:', error))
                        .finally(() => {
                            // Hide the loading animation
                            loadingContainer.classList.add('hidden');
                        });
                }
            });
        });

        closeModalButton.addEventListener('click', function() {
            // Hide the modal
            detailModal.classList.add('hidden');
            document.getElementById('modal-overlay').classList.add('hidden');

        });


        window.addEventListener('click', function(event) {
            if (event.target === detailModal) {
                detailModal.classList.add('hidden');
            }
        });


        // Function to search and highlight rows based on the input
        function searchAndHighlight(tableId, searchColumnIndex) {
            const input = document.getElementById('topbar-search').value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                const cells = rows[i].getElementsByTagName('td');
                const cell = cells[searchColumnIndex];
                if (cell) {
                    const text = cell.textContent || cell.innerText;
                    if (text.toLowerCase().indexOf(input) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        const cek1 = document.getElementById('delete-form');
        if (cek1) {
            document.getElementById('delete-form').addEventListener('submit', function(e) {
                const confirmSubmit = confirm('Are you sure you want to delete the data?');
                if (!confirmSubmit) {
                    e.preventDefault(); // Prevent form submission if user cancels
                    return;
                }
            });
        }

        const cek2 = document.getElementById('delete-form-bk');
        if (cek2) {
            document.getElementById('delete-form-bk').addEventListener('submit', function(e) {
                const confirmSubmit = confirm('Are you sure you want to delete the data?');
                if (!confirmSubmit) {
                    e.preventDefault(); // Prevent form submission if user cancels
                    return;
                }
            });
        }

        document.getElementById('topbar-search').addEventListener('input', function() {
            const tandaTerimaTableVisible = !document.getElementById('tanda-terima-table').classList.contains('hidden');
            const tableId = tandaTerimaTableVisible ? 'tanda-terima-table' : 'bukti-kas-keluar-table';
            const searchColumnIndex = tandaTerimaTableVisible ? 0 : 1; // Search by index for tanda-terima and nomer for bukti-kas
            searchAndHighlight(tableId, searchColumnIndex);
        });

        // On initial load
        const currentPath = window.location.pathname;
        if (currentPath === '/dashboard/all/tanda-terima') {
            switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link', '/dashboard/all/tanda-terima');
        } else if (currentPath === '/dashboard/all/bukti-kas') {
            switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link', '/dashboard/all/bukti-kas');
        }


        const searchBar = document.getElementById('topbar-search');
        searchBar.addEventListener('input', () => {
            searchAndHighlight('tanda-terima-table', 1); // Search by index for tanda-terima-table
            searchAndHighlight('bukti-kas-keluar-table', 1); // Search by nomer for bukti-kas-keluar-table
        });


        const supplierDropdown = document.getElementById('supplier');
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        supplierDropdown.addEventListener('change', filterTableRows);
        startDateInput.addEventListener('input', filterTableRows);
        endDateInput.addEventListener('input', filterTableRows);
    });
</script>

<style>
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>