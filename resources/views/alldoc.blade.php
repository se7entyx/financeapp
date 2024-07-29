<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full">
        <nav class="bg-gray-800 border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center space-x-8">
                    <a href="/dashboard/all/tanda-terima" class="text-gray-300 hover:text-white" id="tanda-terima-link">Tanda Terima</a>
                    <a href="/dashboard/all/bukti-kas" class="text-gray-300 hover:text-white" id="bukti-kas-keluar-link">Bukti Kas Keluar</a>
                </div>
                <div class="flex justify-center items-center">
                    <form action="#" method="GET" class="hidden lg:block lg:pl-2">
                        <label for="topbar-search" class="sr-only">Search</label>
                        <div class="relative mt-1 lg:w-96">
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
        <div class="container">
            <div id="tanda-terima-table" class="max-h-screen overflow-y-auto bg-white shadow-md rounded-lg hidden">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="sticky top-0 bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="py-2 px-4 border-b"></th>
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
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->index + 1 }}</td>
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
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center">
                                <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $tt->id }}" data-table="tanda-terima">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="bukti-kas-keluar-table" class="max-h-screen overflow-y-auto bg-white shadow-md rounded-lg hidden">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="sticky top-0 bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="py-2 px-4 border-b">No.</th>
                            <th class="py-2 px-4 border-b">Nomer</th>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Dibayarkan Kepada</th>
                            <th class="py-2 px-4 border-b">Kas/Cheque/Bilyet Giro Bank</th>
                            <th class="py-2 px-4 border-b">Jumlah USD / Rp</th>
                            <th class="py-2 px-4 border-b">No. Cek</th>
                            <th class="py-2 px-4 border-b">Tanggal Jatuh Tempo</th>
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
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center jumlah">{{ $bk->jumlah }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center no-cek">{{ $bk->no_cek }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center jatuh-tempo">{{ $bk->tanda_terima->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center dibuat-oleh">{{ $bk->user->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center">
                                <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $bk->id }}" data-table="bukti-kas">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal -->
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

        document.querySelectorAll('.view-details').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const typeId = this.getAttribute('data-id');
                const tableType = this.getAttribute('data-table');

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
                    const dibuatOleh = row.querySelector('.dibuat-oleh').textContent;

                    fetch(`/bukti-kas/${typeId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            detailsContent.innerHTML = `
                        <div class="mb-4"><strong>Nomer:</strong> ${nomer}</div>
                        <div class="mb-4"><strong>Tanggal:</strong> ${tanggal || 'N/A'}</div>
                        <div class="mb-4"><strong>Dibayarkan kepada:</strong> ${dibayarkanKepada || 'N/A'}</div>
                        <div class="mb-4"><strong>Kas/Cheque/Bilyet Giro Bank:</strong> ${dibayarkan || 'N/A'}</div>
                        <div class="mb-4"><strong>Jumlah:</strong> ${jumlah || 'N/A'}</div>
                        <div class="mb-4"><strong>No. Cek:</strong> ${noCek || 'N/A'}</div>
                        <div class="mb-4"><strong>Tanggal Jatuh Tempo:</strong> ${tanggalJatuhTempo || 'N/A'}</div>
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
                                ${data.keterangan_bukti_kas.map((kbk, index) => `
                                    <tr>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${index + 1}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/2">${kbk.keterangan}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${kbk.dk}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/6">${kbk.jumlah}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                            // Show the modal
                            detailModal.classList.remove('hidden');
                        })
                        .catch(error => console.error('Error fetching KeteranganBuktiKas details:', error));

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
                                ${data.map((kbk, index) => `
                                    <tr>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${index + 1}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${kbk.nomor}</td>
                                        <td scope="col" class="py-2 px-4 border-b w-1/3">${kbk.nominal}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                            // Show the modal
                            detailModal.classList.remove('hidden');
                        })
                        .catch(error => console.error('Error fetching tandaTerimaInvoices details:', error));
                }
            });
        });

        closeModalButton.addEventListener('click', function() {
            // Hide the modal
            detailModal.classList.add('hidden');
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

        document.addEventListener('DOMContentLoaded', () => {
            const searchBar = document.getElementById('topbar-search');
            searchBar.addEventListener('input', () => {
                searchAndHighlight('tanda-terima-table', 0); // Search by index for tanda-terima-table
                searchAndHighlight('bukti-kas-keluar-table', 1); // Search by nomer for bukti-kas-keluar-table
            });
        });
    });
</script>

<style>
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>