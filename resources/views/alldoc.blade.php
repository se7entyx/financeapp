<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full">
        <nav class="bg-gray-800 p-4 mb-6">
            <div class="container mx-auto flex justify-center">
                <div class="space-x-8">
                    <a href="#" class="text-white hover:text-white" id="tanda-terima-link">Tanda Terima</a>
                    <a href="#" class="text-gray-300 hover:text-white" id="bukti-kas-keluar-link">Bukti Kas Keluar</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <!-- table tanda terima -->
            <div id="tanda-terima-table" class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
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

            <!-- table bukti kas -->
            <div id="bukti-kas-keluar-table" class="overflow-x-auto bg-white shadow-md rounded-lg hidden">
                <p>tes</p>
            </div>
        </div>
    </section>
</x-layout>

<script>
    function switchTable(showTableId, hideTableId, activeLinkId, inactiveLinkId) {
        document.getElementById(showTableId).classList.remove('hidden');
        document.getElementById(hideTableId).classList.add('hidden');
        document.getElementById(activeLinkId).classList.add('text-white');
        document.getElementById(activeLinkId).classList.remove('text-gray-300');
        document.getElementById(inactiveLinkId).classList.remove('text-white');
        document.getElementById(inactiveLinkId).classList.add('text-gray-300');
    }

    // Set event listeners for the nav links
    document.getElementById('tanda-terima-link').addEventListener('click', function() {
        switchTable('tanda-terima-table', 'bukti-kas-keluar-table', 'tanda-terima-link', 'bukti-kas-keluar-link');
    });

    document.getElementById('bukti-kas-keluar-link').addEventListener('click', function() {
        switchTable('bukti-kas-keluar-table', 'tanda-terima-table', 'bukti-kas-keluar-link', 'tanda-terima-link');
    });
</script>