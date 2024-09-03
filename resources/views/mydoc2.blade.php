<x-layout>
    @section('title', 'My Bukti Pengeluaran Kas / Bank')
    <style>
        .required {
            color: red;
        }
    </style>
    @php
    $startYear = date('Y');
    $endYear = $startYear + 7;
    @endphp
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
            <div class="flex flex-wrap justify-end items-center">

                <!-- Middle section: Supplier and Dates -->
                <div class="flex flex-wrap justify-bet items-center space-x-2 lg:space-x-4 mt-2 lg:mt-0">
                    <form id="filter-form" action="#" method="GET" class="flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto m-0 p-0 items-center">
                        <div class="relative mt-1 lg:mt-0 inline-flex">
                            <a href="/dashboard/my/bukti-kas"> <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><span class="fa-solid fa-filter-circle-xmark"></span> Clear</button></a>
                        </div>
                        <div class="relative mt-1 lg:mt-0">
                            <label for="jatuh_tempo" class="sr-only">Jatuh Tempo</label>
                            <input type="date" id="jatuh_tempo" name="jatuh_tempo" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        </div>
                        <div class="relative mt-1 lg:mt-0 w-2/3">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container flex-grow overflow-auto">
            <div id="bukti-kas-keluar-table" class="bg-white shadow-md rounded-lg">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="sticky top-0 bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Nomor Bukti Kas Keluar</th>
                            <th class="py-2 px-4 border-b">@sortablelink('tanggal','Tanggal')</th>
                            <th class="py-2 px-4 border-b">Dibayarkan kepada</th>
                            <th class="py-2 px-4 border-b text-center">Kas</th>
                            <th class="py-2 px-4 border-b text-center">Jumlah</th>
                            <th class="py-2 px-4 border-b text-center">No Cek</th>
                            <th class="py-2 px-4 border-b">@sortablelink('tanda_terima.tanggal_jatuh_tempo','Tanggal Jatuh Tempo')</th>
                            <th class="py-2 px-4 border-b">Berita Transaksi</th>
                            <th class="py-2 px-4 border-b">@sortablelink('created_at','Kapan dibuat')</th>
                            <th class="py-2 px-4 border-b">Kapan diupdate</th>
                            <th class="py-2 px-4 border-b">Pembuat</th>
                            <th class="py-2 px-4 border-b">@sortablelink('status','Status')</th>
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
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center no-cek">{{ $bk->no_cek ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center jatuh-tempo">{{ $bk->tanda_terima->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center berita-transaksi">{{ $bk->berita_transaksi}}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center kapan-dibuat">{{ $bk->created_at->format('d-m-Y')}}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center kapan-diupdate">{{ $bk->updated_at->format('d-m-Y')}}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center dibuat-oleh">{{ $bk->user->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center status {{ $bk->status === 'Belum dibayar' ? 'text-red-500' : ($bk->status === 'Sudah dibayar' ? 'text-green-500' : 'text-gray-500') }}">
                                {{ $bk->status }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 text-center inline-flex">
                                <div class="flex justify-center items-center space-x-4">
                                    <a href="#" class="text-blue-500 hover:text-blue-700 view-details" data-id="{{ $bk->tanda_terima_id }}" data-table="bukti-kas">View Details</a>
                                    <a href="/dashboard/edit/bukti-kas/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 edit" data-id="{{ $bk->id }}" data-table="bukti-kas">Edit</a>
                                    <form action="/bukti-kas/{{$bk->id}}/delete" method="POST" class="inline-block m-0 p-0 delete-form-bk">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-blue-500 hover:text-blue-700 delete-link p-0 m-0 border-0 bg-transparent cursor-pointer">Delete</button>
                                    </form>
                                    <button id='finish-button' type="button" data-modal-target="finishModal" data-modal-toggle="finishModal" class="flex w-full items-center dark:hover:bg-gray-600 dark:hover:text-white text-blue-500 hover:text-blue-700 dark:text-gray-200" data-nomer="{{ $bk->nomer }}" data-tanggal="{{ $bk->tanggal }}" data-user-id="{{ $bk->id }}">
                                        Finish
                                    </button>
                                    <a href="/dashboard/print/bukti-kas/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 print" target="_blank" rel="noopener noreferrer">Print</a>
                                    <a href="/dashboard/print/mandiri/{{$bk->id}}" class="text-blue-500 hover:text-blue-700 print" target="_blank" rel="noopener noreferrer">Print Mandiri</a>
                                </div>
                            </td>
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
                            <h2 class="text-2xl font-bold mb-4">Detail</h2>
                            <div id="details-content">
                                <!-- Details will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="finishModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Finish Bukti Kas</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="finishModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form id='finish-form' action="/dashboard/finish/bukti-kas/" method="post">
                            @method('PUT')
                            @csrf
                            <div class="grid mb-6 gap-4 sm:grid-cols-1">
                                <div class="mb-6">
                                    <label for="nomer-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer <span class="required">*</span></label>
                                    <div class="flex space-x-2">
                                        <select id="dropdown-kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="RMK">RMK</option>
                                            <option value="DMK">DMK</option>`
                                        </select>
                                        <input type="text" id="input-nomor" name="input-nomor" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan nomor" required>
                                        <select id="dropdown-bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                            <option value="V">V</option>
                                            <option value="VI">VI</option>
                                            <option value="VII">VII</option>
                                            <option value="VIII">VIII</option>
                                            <option value="IX">IX</option>
                                            <option value="X">X</option>
                                            <option value="XI">XI</option>
                                            <option value="XII">XII</option>
                                        </select>
                                        <select id="dropdown-tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            @for ($year = $startYear; $year <= $endYear; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <input type="hidden" id="nomer" name="nomer" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                                <div class="mb-6">
                                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal pembayaran <span class="required">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input name="tanggal" id="datepicker-autohide-tanggal" datepicker datepicker-autohide datepicker-orientation="top left" autocomplete="off" type="text" datepicker-format="dd-mm-yyyy" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" required>
                                    </div>
                                </div>
                                <div class="flex justify-center">
                                    <button id="submit-btn" type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4">
            {{ $buktiKasRecords->links() }}
        </div>
    </section>

</x-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {

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

                const row = this.closest('tr');
                const nomer = row.querySelector('.nomer').textContent;
                const tanggal = row.querySelector('.tanggal').textContent;
                const dibayarkanKepada = row.querySelector('.dibayarkan-kepada').textContent;
                const dibayarkan = row.querySelector('.kas').textContent;
                const jumlah = row.querySelector('.jumlah').textContent;
                const noCek = row.querySelector('.no-cek').textContent;
                const tanggalJatuhTempo = row.querySelector('.jatuh-tempo').textContent;
                const beritaTransaksi = row.querySelector('.berita-transaksi').textContent;
                const kapanDibuat = row.querySelector('.kapan-dibuat').textContent;
                const kapanDiupdate = row.querySelector('.kapan-diupdate').textContent;
                const dibuatOleh = row.querySelector('.dibuat-oleh').textContent;
                const status = row.querySelector('.status').textContent;

                fetch(`/bukti-kas/${typeId}/invoices`)
                    .then(response => response.json())
                    .then(data => {
                        const formatter = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });

                        // Fill the details in the modal
                        detailsContent.innerHTML = `
                    <div class="mb-4"><strong>Nomer:</strong> ${nomer}</div>
                    <div class="mb-4"><strong>Tanggal:</strong> ${tanggal || 'N/A'}</div>
                    <div class="mb-4"><strong>Dibayarkan kepada:</strong> ${dibayarkanKepada || 'N/A'}</div>
                    <div class="mb-4"><strong>Kas/Cheque/Bilyet Giro Bank:</strong> ${dibayarkan || 'N/A'}</div>
                    <div class="mb-4"><strong>Jumlah:</strong> ${jumlah || 'N/A'}</div>
                    <div class="mb-4"><strong>No. Cek:</strong> ${noCek || 'N/A'}</div>
                    <div class="mb-4"><strong>Tanggal Jatuh Tempo:</strong> ${tanggalJatuhTempo || 'N/A'}</div>
                    <div class="mb-4"><strong>Berita Transaksi:</strong> ${beritaTransaksi || 'N/A'}</div>
                    <div class="mb-4"><strong>Kapan dibuat:</strong> ${kapanDibuat || 'N/A'}</div>
                    <div class="mb-4"><strong>Kapan diupdate:</strong> ${kapanDiupdate || 'N/A'}</div>
                    <div class="mb-4"><strong>Dibuat oleh:</strong> ${dibuatOleh || 'N/A'}</div>
                    <div class="mb-4"><strong>Status:</strong> ${status || 'N/A'}</div>
                    <div class="mb-4"><strong>Keterangan Bukti Kas:</strong></div>
                    <table class="w-full bg-white rtl:text-right border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr class="text-gray-700">
                                <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">No</th>
                                <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">Keterangan</th>
                                <th scope="col" class="py-2 px-4 border-b w-1/3 text-start">Nominal</th>
                            </tr>
                        </thead>
                        <tbody id="buktiTable"></tbody>
                    </table>
                `;

                        // Populate the table using renderTable function
                        renderTable(data, formatter);

                        // Show the modal
                        detailModal.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error fetching Keterangan Bukti Kas details:', error))
                    .finally(() => {
                        // Hide the loading animation
                        loadingContainer.classList.add('hidden');
                    });
            });
        });

        function renderTable(bukti, formatter) {
            const buktiTable = document.getElementById('buktiTable');
            buktiTable.innerHTML = ''; // Clear existing rows

            let rowIndex = 1;
            bukti.forEach((item, index) => {
                const isFirstTransaction = index === 0 || bukti[index - 1].invoice_keterangan !== item.invoice_keterangan;

                const newRow = buktiTable.insertRow();
                newRow.className = "bg-white border-b";

                if (isFirstTransaction) {
                    const cellNo = newRow.insertCell(0);
                    cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap";
                    cellNo.textContent = rowIndex++;

                    const cellKeterangan = newRow.insertCell(1);
                    cellKeterangan.className = "px-6 py-4";
                    cellKeterangan.textContent = `${item.transaction_keterangan} (${item.invoice_keterangan})`;

                    const cellAmount = newRow.insertCell(2);
                    cellAmount.className = "px-6 py-4 text-right";
                    cellAmount.textContent = item.currency + ' ' + formatter.format(item.transaction_nominal);
                } else {
                    const cellNo = newRow.insertCell(0);
                    cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap";
                    cellNo.textContent = '';

                    const cellKeterangan = newRow.insertCell(1);
                    cellKeterangan.className = "px-6 py-4";
                    cellKeterangan.textContent = item.transaction_keterangan;

                    const cellAmount = newRow.insertCell(2);
                    cellAmount.className = "px-6 py-4 text-right";
                    cellAmount.textContent = item.currency + ' ' + formatter.format(item.transaction_nominal);
                }

                // Add tax rows if PPn or PPh exists
                if (item.nominal_ppn) {
                    addTaxRow('PPn', item.transaction_nominal, item.currency, newRow, item.name_ppn, item.nominal_ppn);
                }
                if (item.nominal_pph) {
                    addTaxRow('PPh', item.transaction_nominal, item.currency, newRow, item.name_pph, item.nominal_pph);
                }
            });
        }

        function addTaxRow(type, baseAmount, currency, referenceRow, existingTaxName = null, existingTaxAmount = null) {
            const buktiTable = document.getElementById('buktiTable');

            // Calculate the index for the new row
            let newIndex = referenceRow.rowIndex + 1;

            // Ensure the index is within the valid range
            if (newIndex > buktiTable.rows.length) {
                newIndex = -1; // Insert at the end of the table
            }

            const newRow = buktiTable.insertRow(newIndex);
            newRow.className = "bg-gray-100 border-b";

            const cellNo = newRow.insertCell(0);
            cellNo.className = "px-6 py-4";

            const cellKeterangan = newRow.insertCell(1);
            cellKeterangan.className = "px-6 py-4";
            cellKeterangan.textContent = `${existingTaxName || 'Auto'}`;

            const cellAmount = newRow.insertCell(2);
            cellAmount.className = "px-6 py-4 text-right";
            cellAmount.textContent = currency + ' ' + formatter.format(existingTaxAmount || 0);
        }


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
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const confirmSubmit = confirm('Are you sure you want to delete the data?');
                if (!confirmSubmit) {
                    e.preventDefault(); // Prevent form submission if user cancels
                    return;
                }
            });
        });
        document.querySelectorAll('.delete-form-bk').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const confirmSubmit = confirm('Are you sure you want to delete the data?');
                if (!confirmSubmit) {
                    e.preventDefault(); // Prevent form submission if user cancels
                    return;
                }
            });
        });

        document.querySelectorAll('[data-nomer]').forEach(button => {
            button.addEventListener('click', function() {
                updateNomer();
                const id = this.getAttribute('data-user-id');
                const nomer = this.getAttribute('data-nomer');
                const tanggal = this.getAttribute('data-tanggal');

                // Populate the update modal with user data
                const finishForm = document.getElementById('finish-form');
                if (finishForm) {
                    finishForm.action = '/dashboard/finish/bukti-kas/' + id;
                    // Split the 'nomer' value
                    const nomerParts = nomer.split(/\s*\/\s*/);
                    const kode = nomerParts[0];
                    const nomor = nomerParts[1];
                    const bulan = nomerParts[2];
                    const tahun = nomerParts[3];

                    // Set the select options
                    document.getElementById('dropdown-kode').value = kode;
                    document.getElementById('dropdown-bulan').value = bulan;
                    document.getElementById('dropdown-tahun').value = tahun;
                    document.getElementById('input-nomor').value = nomor;
                    document.getElementById('datepicker-autohide-tanggal').value = tanggal;
                    updateNomer();
                }
            });
        });

        document.querySelectorAll('#dropdown-kode, #dropdown-bulan, #dropdown-tahun, #input-nomor').forEach(input => {
            input.addEventListener('input', updateNomer);
        });

        function updateNomer() {
            const part1 = document.getElementById('dropdown-kode').value;
            const part4 = document.getElementById('input-nomor').value;
            const part2 = document.getElementById('dropdown-bulan').value;
            const part3 = document.getElementById('dropdown-tahun').value;
            const part4Formatted = part4 ? part4 : '\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0';
            const nomer = `${part1}/${part4Formatted}/${part2}/${part3}`;
            document.getElementById('nomer').value = nomer;
            console.log(nomer);
        }
    });
</script>

<style>
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>