<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full">
        <nav class="bg-gray-800 p-4 mb-6">
            <div class="container mx-auto flex justify-center">
                <div class="space-x-8">
                    <a href="/dashboard/all/tanda-terima" class="text-white hover:text-white" id="tanda-terima-link">Tanda Terima</a>
                    <a href="/dashboard/all/bukti-kas" class="text-gray-300 hover:text-white" id="bukti-kas-keluar-link">Bukti Kas Keluar</a>
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
                <p>tes</p>
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
