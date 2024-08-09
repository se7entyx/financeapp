<x-layout>
    @section('title', 'Edit Tanda Terima')
    <style>
        .required {
            color: red;
        }
    </style>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900">
        @if (session('success'))
        <div class="alert alert-success">
            <script>
                alert("Tanda terima berhasil diedit");
            </script>
        </div>
        @endif
        <div class="py-8 px-4 mx-auto max-w-7xl">
            <form id="edittandaterima" action="/dashboard/edit/tanda-terima/{{$tandaTerimaRecords->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier <span class="required">*</span></label>
                        <select id="supplier_id" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled selected>Select supplier</option>
                            @foreach ($suppliers as $supplier)

                            @if ($supplier->id == $tandaTerimaRecords->supplier_id)
                            <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                            @endif

                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal <span class="required">*</span></label>
                        <input type="text" id="tanggal" name="tanggal" value="{{$tandaTerimaRecords->tanggal}}" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-2 md:col-span-1 lg:col-span-2">
                        <label for="Lampiran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lampiran</label>
                        <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <input type="hidden" name="faktur" value="false">
                            <input type="hidden" name="po" value="false">
                            <input type="hidden" name="bpb" value="false">
                            <input type="hidden" name="sjalan" value="false">
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <!-- <input type="hidden" name="faktur" value="false"> -->
                                    <input id="faktur-checkbox" name="faktur" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" @if ($tandaTerimaRecords->pajak == "true")
                                    checked
                                    @endif value="true">
                                    <label for="faktur-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Faktur Pajak</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="po-checkbox" name="po" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" @if ($tandaTerimaRecords->po == "true")
                                    checked
                                    @endif>
                                    <label for="po-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">PO</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="bpb-checkbox" name="bpb" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" @if ($tandaTerimaRecords->bpb == "true")
                                    checked
                                    @endif>
                                    <label for="bpb-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">BPB</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="sjalan-checkbox" name="sjalan" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" @if ($tandaTerimaRecords->sjalan == "true")
                                    checked
                                    @endif>
                                    <label for="sjalan-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Surat Jalan</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-3 justify-center items-center">
                        <div class="flex items-center">
                            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" id="addButton">Add</button>
                            <select name="currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 ml-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if ($tandaTerimaRecords->currency == 'IDR')
                                <option value="IDR" selected>IDR</option>
                                <option value="USD">USD</option>
                                @elseif ($tandaTerimaRecords->currency == 'USD')
                                <option value="IDR">IDR</option>
                                <option value="USD" selected>USD</option>
                                @endif
                            </select>
                        </div>
                        <div id="invoiceFieldsContainer">
                            <!-- Invoice fields will be appended here -->
                            @foreach ($tandaTerimaRecords->invoices as $invoice)
                            <!-- {{$invoice->id}} -->
                            <div class="invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end">
                                <div class="flex-1">
                                    <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice <span class="required">*</span></label>
                                    <input type="text" name="invoice[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice" value="{{$invoice->nomor}}" required>
                                </div>
                                <div class="flex-1">
                                    <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
                                    <input type="number" name="nominal[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" value="{{$invoice->nominal}}" required>
                                </div>
                                <div class="flex-shrink-0 min-w-[200px] mt-4 md:mt-0">
                                    <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeItem(this)">Delete</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1 lg:col-span-2">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Jatuh Tempo <span class="required">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" name="jatuh_tempo" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy" value="{{$tandaTerimaRecords->tanggal_jatuh_tempo}}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">
                        {{trim(old('notes', $tandaTerimaRecords->keterangan))}}
                        </textarea>
                    </div>
                    <div class="sm:col-span-4 md:col-span-1 lg:col-span-4 flex justify-center">
                        <button type="submit" id="submitform" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Submit
                        </button>
                        <button type="" class="inline-flex ml-4 items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Preview
                        </button>
                    </div>
            </form>
        </div>
    </section>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle checkbox values between 'true' and 'false'
        function toggleCheckboxValue(checkboxId) {
            document.getElementById(checkboxId).addEventListener('change', function() {
                this.value = this.checked ? 'true' : 'false';
            });
        }

        toggleCheckboxValue('faktur-checkbox');
        toggleCheckboxValue('po-checkbox');
        toggleCheckboxValue('bpb-checkbox');
        toggleCheckboxValue('sjalan-checkbox');

        // Set current date in "tanggal" field
        const now = new Date();
        const formattedDate = now.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        document.getElementById('tanggal').value = formattedDate;
        console.log("Formatted Date:", formattedDate);
        var form = document.getElementById('edittandaterima');

        const addButton = document.getElementById('addButton');
        const invoiceFieldsContainer = document.getElementById('invoiceFieldsContainer');
        let currentEditIndex = null;

        // Function to format currency
        function formatCurrency(value, currency) {
            return `${currency} ${new Intl.NumberFormat('id-ID').format(value)}`;
        }

        let invoiceCount = 0;
        // Add new invoice fields dynamically
        addButton.addEventListener('click', function() {
            invoiceCount++;
            const div = document.createElement('div');
            div.className = 'invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end mt-2'; // Flex container with responsive direction

            div.innerHTML = `
        <div class="flex-1">
            <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>
            <input type="text" name="invoice[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice" required>
        </div>
        <div class="flex-1">
            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal</label>
            <input type="number" name="nominal[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" required>
        </div>
        <div class="flex-1">
            <label for="currency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
            <select name="currency[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="IDR" selected>IDR</option>
                <option value="USD">USD</option>
            </select>
        </div>
        <div class="flex-shrink-0 min-w-[200px] mt-4 md:mt-0">
            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeItem(this)">Delete</button>
        </div>
    `;

            invoiceFieldsContainer.appendChild(div);
        });
        form.addEventListener('submit', function(event) {
            var invoiceRow = document.getElementsByClassName('invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end');
            var invoiceCount = invoiceRow.length;

            if (invoiceCount == 0) {
                alert('Anda harus input minimal 1 invoice');
                event.preventDefault(); // Prevent the form from submitting
            }
        });
    });

    function removeItem(button) {
        console.log('button clicked');
        // Find the closest parent element with the class 'invoice-row' and remove it
        const row = button.closest('.invoice-row');
        if (row) {
            row.remove();
            invoiceCount--; // Decrement the invoice count after removing the item
        }
    }
</script>