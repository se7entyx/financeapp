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
                            <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tandaTerimaRecords as $tt)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->index + 1 }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $tt->tanggal }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $tt->supplier->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500">
                                {!! $tt->pajak == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500">
                                {!! $tt->po == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500">
                                {!! $tt->bpb == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-center text-gray-500">
                                {!! $tt->surat_jalan == 'true' ? '<span class="text-green-500">&#10003;</span>' : '<span class="text-red-500">&#10007;</span>' !!}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $tt->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 text-sm text-gray-500 break-words">{{ $tt->keterangan ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $tt->user->name ?? 'N/A' }}</td>
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
                            <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->index + 1 }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->nomer }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->tanggal ?? 'N/A' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->tanda_terima->supplier->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->kas }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->jumlah }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->no_cek }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->tanda_terima->tanggal_jatuh_tempo }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ $bk->user->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">{{ `<a  href=# class="text-blue-500 hover:text-blue-700">
                                View Details
                                </a>` }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layout>


<script>
    function switchTable(showTableId, hideTableId, activeLinkId, inactiveLinkId, newUrl) {
        document.getElementById(showTableId).classList.remove('hidden');
        document.getElementById(hideTableId).classList.add('hidden');
        document.getElementById(activeLinkId).classList.add('text-white');
        document.getElementById(activeLinkId).classList.remove('text-gray-300');
        document.getElementById(inactiveLinkId).classList.remove('text-white');
        document.getElementById(inactiveLinkId).classList.add('text-gray-300');

        // Update the URL without reloading the page
        window.history.pushState(null, '', newUrl);
    }

    // Set event listeners for the nav links
    document.getElementById('tanda-terima-link').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link', '/dashboard/all/tanda-terima');
    });

    document.getElementById('bukti-kas-keluar-link').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link', '/dashboard/all/bukti-kas');
    });

    // Handle back/forward navigation
    window.addEventListener('popstate', function(event) {
        if (window.location.pathname === '/dashboard/all/tanda-terima') {
            switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link', '/dashboard/all/tanda-terima');
        } else if (window.location.pathname === '/dashboard/all/bukti-kas') {
            switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link', '/dashboard/all/bukti-kas');
        }
    });

    // Initialize the correct table based on the current URL
    if (window.location.pathname === '/dashboard/all/tanda-terima') {
        switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link', '/dashboard/all/tanda-terima');
    } else if (window.location.pathname === '/dashboard/all/bukti-kas') {
        switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link', '/dashboard/all/bukti-kas');
    }
</script>

<style>
    thead.sticky th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>