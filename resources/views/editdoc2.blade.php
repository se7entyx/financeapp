<x-layout>
@section('title', 'Edit Bukti Pengeluaran Kas')
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900 w-full">
        <div class="py-4 px-8 mx-auto max-w-7xl">
            <form id="my-form" action="/dashboard/edit/bukti-kas/{{$buktiKasRecords->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="grid gap-x-8 gap-y-4 mb-6 lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1">
                    <div class="col-span-1">
                        <label for="nomer-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer</label>
                        <input type="text" id="nomer" name="nomer" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$buktiKasRecords->nomer}}" placeholder="Masukan nomor" />
                    </div>
                    <div class="col-span-1">
                        <label for="input-part2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input name="tanggal" id="datepicker-autohide" datepicker datepicker-format="dd-mm-yyyy" datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih Tanggal" value="{{$buktiKasRecords->tanggal}}">
                        </div>
                    </div>
                    <!-- <div class="col-span-1">
                        <label for="input-part3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibayarkan kepada</label>
                        <input type="text" name="tanda_terima_id" id="input-no-tanda-terima" placeholder="Masukan nomor tanda terima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$buktiKasRecords->tanda_terima->supplier->name}}" other="{{$buktiKasRecords->tanda_terima->increment_id}}">
                        <input type="hidden" name="tanda_terima_id_hidden" id="input-no-tanda-terima-hidden" value="{{$buktiKasRecords->tanda_terima_id}}">
                    </div> -->
                    <!-- <div class="col-span-1">
                        <label for="input-part3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Tanda Terima</label>
                        <input type="text" value="{{$buktiKasRecords->tanda_terima->increment_id}}" id="input-no-tanda-terima" placeholder="Masukan nomor tanda terima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div> -->
                    <div class="col-span-1">
                        <label for="dropdown-no-tanda-terima" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Tanda Terima</label>
                        <select id="dropdown-no-tanda-terima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($tandaTerimas as $tandaTerima)
                            <option value="{{ $tandaTerima->increment_id }}" {{ $buktiKasRecords->tanda_terima && $tandaTerima->increment_id == $buktiKasRecords->tanda_terima->increment_id ? 'selected' : '' }}>
                                {{ $tandaTerima->increment_id }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="input-part3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibayarkan kepada</label>
                        <input type="text" id="input-supplier" name="supplier-name" value="{{$buktiKasRecords->tanda_terima->supplier->name}}" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Automatic Input" readonly>
                        <input type="hidden" id="input-no-tanda-terima-hidden" name="tanda_terima_id_hidden" value="{{$buktiKasRecords->tanda_terima_id}}" readonly>
                    </div>
                    <div class="col-start-1">
                        <label for="input-part4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kas/Cheque/Bilyet Giro Bank</label>
                        <input type="text" id="input-bank" name="kas" value="Mandiri" class=" bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    <div class="col-span-1">
                        <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. cek</label>
                        <input type="number" id="number-input" name="no_cek" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan nomor" value="{{$buktiKasRecords->no_cek}}" />
                    </div>
                    <div class="col-span-1">
                        <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal jatuh tempo</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide-x" datepicker-format="dd-mm-yyyy" datepicker-autohide type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 cursor-not-allowed focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Automatic input" value="{{$buktiKasRecords->tanda_terima->tanggal_jatuh_tempo}}" readonly>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label for="berita_transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berita Transaksi</label>
                        <input type="text" id="berita_transaksi" name="berita_transaksi" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan berita" value="{{ $buktiKasRecords->berita_transaksi }}" required>
                    </div>
                    <div class="lg:col-start-1 lg:col-span-2 md:col-span-1 sm:col-span-1">
                        <label for="notes-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <textarea id="notes-input" rows="1" class="bg-gray-50 block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="lg:col-span-2 flex md:col-span-1 sm:col-span-1">
                        <div class="mr-8">
                            <label for="dk-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">D/K</label>
                            <select id="dk-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="" disabled>D/K</option>
                                <option value="D">D</option>
                                <option value="K">K</option>
                            </select>
                        </div>
                        <div class="mr-8">
                            <label for="jumlah-input-2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                            <div class="flex w-3/2">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                        </svg>
                                    </div>
                                    <input type="number" id="currency-input-2" class="block p-2.5 w-full z-20 ps-10 text-sm text-gray-900 bg-gray-50 rounded-s-lg border-e-gray-50 border-e-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Masukan jumlah" min="0" />
                                </div>
                                <button id="currency-button-1" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                    {{$buktiKasRecords->tanda_terima->currency}}
                                </button>
                                <!-- <div id="dropdown-currency-2" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-36 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-currency-button-2">
                                        <li>
                                            <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem-2" data-currency-2="IDR">
                                                <div class="inline-flex items-center">
                                                    IDR
                                                </div>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem-2" data-currency-2="USD">
                                                <div class="inline-flex items-center">
                                                    USD
                                                </div>
                                            </button>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                        <div>
                            <label for="add-btn" class="block text-white mb-2 text-sm font-medium text-gray-900 dark:text-white">Tambahkan</label>
                            <button id="add-btn" type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Add</button>
                        </div>
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
                                            D/K
                                        </th>
                                        <th scope="col" class="px-6 py-3 border-gray-200 dark:border-gray-700">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3 border-gray-200 dark:border-gray-700">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr class="font-semibold text-gray-900 dark:text-white">
                                        <th scope="row" class="px-6 py-3 text-base">Total</th>
                                        <td></td>
                                        <td></td>
                                        <td class="px-6 py-3">
                                            0
                                        </td>
                                    </tr>
                                </tfoot>
                                <input type="hidden" name="jumlah" id="total-amount">
                                <input type="hidden" id="hiddenBuktiField" name="hiddenBuktiField">
                                <input type="hidden" id="keteranganBuktiKasData" value="{{ $buktiKasRecords->keterangan_bukti_kas->toJson() }}">
                                <input type="hidden" id="currencyData" value="{{ $buktiKasRecords->currency }}">
                            </table>
                        </div>
                    </div>
                    <div class="col-start-4 flex justify-evenly pt-4">
                        <button id="prev-btn" type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Preview</button>
                        <button id="submit-btn" type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Submit</button>
                    </div>
                </div>
            </form>
            <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
            <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 border border-gray-300 dark:border-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Ubah
                            </h3>
                            <button id="cls-btn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="edit-notes-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                                <textarea id="edit-notes-input" rows="1" class="bg-gray-50 block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan"></textarea>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <label for="edit-dk-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">D/K</label>
                                <select id="edit-dk-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="" disabled>D/K</option>
                                    <option value="D">D</option>
                                    <option value="K">K</option>
                                </select>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <label for="jumlah-input-2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                                <div class="flex w-3/2">
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                            </svg>
                                        </div>
                                        <input type="number" id="edit-currency-input-2" class="block p-2.5 w-full z-20 ps-10 text-sm text-gray-900 bg-gray-50 rounded-s-lg border-e-gray-50 border-e-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Masukan jumlah" min="0" />
                                    </div>
                                    <button id="currency-button-2" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                        IDR
                                    </button>
                                    <!-- <div id="dropdown-currency-3" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-36 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-currency-button-2">
                                            <li>
                                                <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem-3" data-currency-3="IDR">
                                                    <div class="inline-flex items-center">
                                                        IDR
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem-3" data-currency-3="USD">
                                                    <div class="inline-flex items-center">
                                                        USD
                                                    </div>
                                                </button>
                                            </li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-start-2 flex justify-end pt-4">
                                <button type="submit" class="text-white text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-3/4" id="save-edit-button">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tandaTerimaInput = document.getElementById('dropdown-no-tanda-terima');
            const tandaTerimaHiddenInput = document.getElementById('input-no-tanda-terima-hidden');
            const supplier = document.getElementById('input-supplier');
            const currency1 = document.getElementById('currency-button-1');
            const currency2 = document.getElementById('currency-button-2');
            const buktiTable = document.getElementById('buktiTable').getElementsByTagName('tbody')[0];
            const addButton = document.getElementById('add-btn');
            let no = 1;
            bukti = [];
            let currentEditRow = null;
            const editModal = document.getElementById('edit-modal');
            const overlay = document.getElementById('modal-overlay');
            let limit = 0;
            // let original = null;

            function updateSupplierInfo() {
                const tandaTerimaId = document.getElementById('dropdown-no-tanda-terima').value;
                const buktiKasId = "{{ $buktiKasRecords->id }}";

                fetch(`/get-supplier-info/${tandaTerimaId}/${buktiKasId}?`) // Ensure the correct parameter name
                    .then(response => response.json())
                    .then(data => {
                        if (data.supplier_name) {
                            if (bukti.length > 0 && bukti[0].selectedCurrency !== data.currency) {
                                // Update all rows to the new currency
                                bukti.forEach((item, index) => {
                                    item.selectedCurrency = data.currency;
                                    buktiTable.rows[index].cells[3].textContent = formatCurrency(item.nominalValue, data.currency);
                                });
                                updateTotal();
                            }
                            document.getElementById('input-no-tanda-terima-hidden').value = data.tanda_terima_id;

                            supplier.value = data.supplier_name;
                            currency1.innerHTML = data.currency;

                            // Update the datepicker field
                            document.getElementById('datepicker-autohide-x').value = data.tanggal_jatuh_tempo;
                        } else {
                            console.log(data);
                            alert('Tanda Terima not found');
                            document.getElementById('datepicker-autohide-x').value = '';
                            document.getElementById('input-no-tanda-terima-hidden').value = '';
                            supplier.value = '';
                            currency1.innerHTML = 'Not Set';
                        }
                    })
                    .catch(error => {
                        alert('Tanda Terima not found');
                        document.getElementById('datepicker-autohide-x').value = '';
                        document.getElementById('input-no-tanda-terima-hidden').value = '';
                        supplier.value = '';
                        currency1.innerHTML = 'Not Set';
                    });
            }

            // Restore the original value and update the hidden input on focus out
            tandaTerimaInput.addEventListener('focusout', updateSupplierInfo);

            document.getElementById('dropdown-no-tanda-terima').addEventListener('change', function() {
                this.blur(); // This will remove focus from the dropdown
            });

            function updateHiddenBuktiField(buktiArray) {
                // Convert the array to a JSON string
                var jsonString = JSON.stringify(buktiArray);

                // Update the hidden input field with the JSON string
                document.getElementById('hiddenBuktiField').value = jsonString;
            }

            // const dropdownButton2 = document.getElementById('dropdown-currency-button-2');
            // const dropdownMenu2 = document.getElementById('dropdown-currency-2');
            // const menuItems2 = dropdownMenu2.querySelectorAll('button[data-currency-2]');
            // const dropdownButton3 = document.getElementById('dropdown-currency-button-3');
            // const dropdownMenu3 = document.getElementById('dropdown-currency-3');
            // const menuItems3 = dropdownMenu3.querySelectorAll('button[data-currency-3]');

            function loadketerangan() {
                // Clear the bukti array
                bukti = [];
                limit = parseInt("{{ $buktiKasRecords->keterangan_bukti_kas->count() }}", 10);
                console.log(limit);

                const storedBukti = document.getElementById('keteranganBuktiKasData').value;
                const currency = '{{$buktiKasRecords->tanda_terima->currency}}';
                if (storedBukti) {
                    parsedBukti = JSON.parse(storedBukti);
                    bukti = parsedBukti.map(item => ({
                        id: item.id,
                        notes: item.keterangan, // Rename 'keterangan' to 'notes'
                        dk: item.dk,
                        nominalValue: item.jumlah, // Rename 'jumlah' to 'nominalValue'
                        selectedCurrency: currency
                    }));
                    updateHiddenBuktiField(bukti);
                    renderTable();
                    console.log('Stored bukti:', bukti);
                }
            }

            // function toggleDropdown(dropdownMenu) {
            //     dropdownMenu.classList.toggle('hidden');
            //     dropdownMenu.classList.toggle('block');
            // }

            // Function to format currency
            function formatCurrency(value, currency) {
                return `${currency} ${new Intl.NumberFormat('id-ID').format(value)}`;
            }

            function updateTotal() {
                const rows = buktiTable.getElementsByTagName('tr');
                let total = 0;
                let currency = '';

                // Iterate through table rows to calculate total and determine currency
                for (let i = 0; i < rows.length; i++) {
                    const cellAmount = rows[i].cells[3].textContent.trim();
                    const parts = cellAmount.split(' ');
                    if (parts.length === 2) {
                        const numericValue = parseFloat(parts[1].replace(/\./g, '').replace(/,/g, '.')); // Handle thousands and decimal separators
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

            // Set default value
            // dropdownButton2.innerHTML = 'IDR <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';

            // menuItems2.forEach(item => {
            //     item.addEventListener('click', function() {
            //         const selectedCurrency2 = this.getAttribute('data-currency-2');
            //         dropdownButton2.innerHTML = `${selectedCurrency2} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>`;
            //         toggleDropdown(dropdownMenu2);
            //     });
            // });

            // menuItems3.forEach(item => {
            //     item.addEventListener('click', function() {
            //         const selectedCurrency3 = this.getAttribute('data-currency-3');
            //         dropdownButton3.innerHTML = `${selectedCurrency3} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>`;
            //         toggleDropdown(dropdownMenu3);
            //     });
            // });

            function updateRowNumbers() {
                const rows = buktiTable.getElementsByTagName('tr');
                for (let i = 0; i < rows.length; i++) {
                    const cell = rows[i].getElementsByTagName('td')[0];
                    cell.textContent = i + 1;
                }
            }

            function openEditModal(rowIndex) {
                currentEditRow = buktiTable.rows[rowIndex];
                console.log(currentEditRow);
                const notes = bukti[rowIndex].notes;
                const dk = bukti[rowIndex].dk;
                const nominalValue = bukti[rowIndex].nominalValue;
                const selectedCurrency = bukti[rowIndex].selectedCurrency;

                document.getElementById('edit-notes-input').value = notes;
                document.getElementById('edit-dk-input').value = dk;
                document.getElementById('edit-currency-input-2').value = nominalValue;
                currency2.innerHTML = currency1.innerHTML.trim();

                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
                overlay.classList.remove('hidden');
            }

            function closeModal(modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                overlay.classList.add('hidden');
            }

            function saveEdit() {
                if (currentEditRow) {
                    console.log(currentEditRow);
                    const editedNotes = document.getElementById('edit-notes-input').value;
                    const editeddk = document.getElementById('edit-dk-input').value;
                    const editedNominalValue = document.getElementById('edit-currency-input-2').value;
                    const editedCurrency = currency2.innerHTML.trim();

                    // if (editedCurrency !== bukti[0].selectedCurrency) {
                    //     if (!confirm(`You are about to change the currency to ${editedCurrency}. This will update all rows to use the new currency. Continue?`)) {
                    //         return;
                    //     }

                    //     // Update all rows to the new currency
                    //     bukti.forEach((item, index) => {
                    //         item.selectedCurrency = editedCurrency;
                    //         buktiTable.rows[index].cells[3].textContent = formatCurrency(item.nominalValue, editedCurrency);
                    //     });

                    //     // Update dropdown buttons
                    //     dropdownButton.innerHTML = `${editedCurrency} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>`;
                    //     dropdownButton2.innerHTML = `${editedCurrency} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>`;
                    // }

                    // Update the row data in the table
                    currentEditRow.cells[1].textContent = editedNotes;
                    currentEditRow.cells[2].textContent = editeddk;
                    currentEditRow.cells[3].textContent = formatCurrency(editedNominalValue, editedCurrency);

                    // Update the bukti array
                    const rowIndex = currentEditRow.rowIndex - 1;
                    bukti[rowIndex] = {
                        id: bukti[rowIndex].id,
                        notes: editedNotes,
                        dk: editeddk,
                        nominalValue: editedNominalValue,
                        selectedCurrency: editedCurrency
                    };

                    console.log('Bukti after edit:', bukti); // Log the array to the console for verification

                    // Hide the modal
                    closeModal(editModal);
                    currentEditRow = null;
                    updateTotal();
                    renderTable();
                }
            }

            function renderTable() {
                // Clear existing rows in the table
                buktiTable.innerHTML = ''; // Clear all rows except for header

                // Render each item in the bukti array
                bukti.forEach((item, index) => {
                    const newRow = buktiTable.insertRow();
                    newRow.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";

                    const cellNo = newRow.insertCell(0);
                    cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
                    cellNo.textContent = index + 1;

                    const cellNotes = newRow.insertCell(1);
                    cellNotes.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                    cellNotes.textContent = item.notes;

                    const celldk = newRow.insertCell(2);
                    celldk.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                    celldk.textContent = item.dk;

                    const cellAmount = newRow.insertCell(3);
                    cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                    cellAmount.textContent = formatCurrency(item.nominalValue, item.selectedCurrency);

                    const cellAction = newRow.insertCell(4);
                    cellAction.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                    cellAction.innerHTML = '<button type="button" class="mr-3 font-medium text-blue-600 dark:text-blue-500 hover:underline editButton" data-modal-toggle="edit-modal">Edit</button> <button type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline deleteButton">Delete</button>';

                    // Add event listener for the delete button

                    // Add event listener for the edit button
                    const editButton = newRow.querySelector('.editButton');
                    editButton.addEventListener('click', function() {
                        openEditModal(newRow.rowIndex - 1); // Pass the row index to the function
                    });

                    const deleteButton = newRow.querySelector('.deleteButton');
                    deleteButton.addEventListener('click', function() {
                        const rowIndex = newRow.rowIndex - 1; // Get the index of the row
                        bukti.splice(rowIndex, 1); // Remove the corresponding bukti from the array
                        limit = limit - 1;
                        console.log(limit);
                        updateTotal(); // Update the total amount
                        renderTable();
                        updateHiddenBuktiField(bukti);
                    });
                });

                // Update the row numbers and total after rendering
                updateRowNumbers();
                updateTotal();
            }

            function addRow(notes, dk, nominalValue, selectedCurrency) {
                // Check if there's an existing row and enforce currency consistency
                // if (bukti.length > 0 && selectedCurrency !== bukti[0].selectedCurrency) {
                //     alert(`Please use the same currency (${bukti[0].selectedCurrency}) as the first row.`);
                //     return;
                // }

                if (notes && dk && nominalValue) {
                    // Store the bukti data in the array
                    limit = limit + 1;
                    console.log(limit);
                    bukti.push({
                        notes: notes,
                        dk: dk,
                        nominalValue: nominalValue,
                        selectedCurrency: selectedCurrency
                    });

                    console.log('Bukti:', bukti); // Log the array to the console for verification

                    // Clear inputs
                    document.getElementById('notes-input').value = '';
                    document.getElementById('dk-input').selectedIndex = 0;
                    document.getElementById('currency-input-2').value = '';

                    // Re-render the table
                    renderTable();
                    updateHiddenBuktiField(bukti);
                }
            }

            // Add the event listener to the button
            addButton.addEventListener('click', function() {
                const notes = document.getElementById('notes-input').value;
                const dk = document.getElementById('dk-input').value;
                const nominalValue = document.getElementById('currency-input-2').value;
                const selectedCurrency = currency1.innerHTML.trim();
                if (selectedCurrency === 'Not Set') {
                    alert('Currency must be set before adding a new row');
                    return;
                }
                if (limit >= 7) {
                    return alert('Melebihi batas keterangan (maksimal 7)');
                }
                addRow(notes, dk, nominalValue, selectedCurrency);
            });


            // document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            //   button.addEventListener('click', () => {
            //     const modal = document.getElementById(button.getAttribute('data-modal-toggle'));
            //     modal.classList.toggle('hidden');
            //   });
            // });

            document.getElementById('save-edit-button').addEventListener('click', function() {
                saveEdit();
                updateHiddenBuktiField(bukti);
            });

            document.getElementById('cls-btn').addEventListener('click', function() {
                closeModal(editModal);
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

            loadketerangan();
        });
    </script>
</x-layout>