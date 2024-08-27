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
                                    <input id="sjalan-checkbox" name="sjalan" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" @if ($tandaTerimaRecords->surat_jalan == "true")
                                    checked
                                    @endif>
                                    <label for="sjalan-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Surat Jalan</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-3 justify-center items-center">
                        <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nota/Kwitansi <span class="required">*</span></label>
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
                                <input type="hidden" name="trans_count[]" class="trans-count" value="0">
                                <div class="flex-1">
                                    <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice <span class="required">*</span></label>
                                    <input type="text" name="invoice[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice" value="{{$invoice->nomor}}" required>
                                </div>
                                <div class="flex-1">
                                    <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
                                    <input type="number" name="nominal[]" readonly class="invoice-nominal bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" required value="{{$invoice->nominal}}">
                                </div>
                                <div class="flex-1">
                                    <div class="flex gap-2">
                                        <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeItem(this)">Delete</button>
                                        <button type="button" id="addTrans" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Add</button>
                                    </div>
                                </div>
                            </div>
                            @foreach ($invoice->transaction as $trans)
                            <div class="trans-row flex flex-col md:flex-row gap-4 mb-6 items-end mt-2 pl-8">
                                <div class="flex-1">
                                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan <span class="required">*</span></label>
                                    <input type="text" name="keterangan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="{{$trans->keterangan}}" placeholder="Keterangan">
                                </div>
                                <div class="flex-1">
                                    <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
                                    <input type="number" name="trans_nominal[]" value="{{$trans->nominal}}"
                                        class="trans-nominal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Nominal">
                                </div>
                                <div class="flex-1">
                                    <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeTransRow(this)">Delete</button>
                                </div>
                            </div>
                            @endforeach
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
                    <div class="sm:col-span-4 md:col-span-1 lg:col-span-4 flex justify-end">
                        <button type="submit" id="submitform" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Submit
                        </button>
                    </div>
            </form>
        </div>
    </section>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('dom');

        function synchronizeRows() {
            // Select all invoice rows
            const invoiceRows = document.querySelectorAll('.invoice-row');

            invoiceRows.forEach(function(invoiceRow) {
                let transCount = 0;
                let nextSibling = invoiceRow.nextElementSibling;

                // Count the associated trans-rows by checking each sibling until another invoice-row or no sibling
                while (nextSibling && nextSibling.classList.contains('trans-row')) {
                    transCount++;
                    nextSibling = nextSibling.nextElementSibling;
                }

                // Update the hidden trans_count input with the correct count
                const transCountInput = invoiceRow.querySelector('.trans-count');
                transCountInput.value = transCount;
                console.log('Synchronized trans count:', transCount);
            });
        }
        synchronizeRows();
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

        addEventListenersToTransNominals();
        // Set current date in "tanggal" field
        const now = new Date();
        const formattedDate = now.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        document.getElementById('tanggal').value = formattedDate;
        console.log("Formatted Date:", formattedDate);

        const form = document.getElementById('edittandaterima');
        const invoiceFieldsContainer = document.getElementById('invoiceFieldsContainer');
        let invoiceCount = 0;

        // Event delegation for adding `trans-row`
        invoiceFieldsContainer.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'addTrans') {
                const invoiceRow = event.target.closest('.invoice-row');
                addTransRow(invoiceRow);
            }
        });

        // document.querySelectorAll('.invoice-nominal').forEach(function(invoiceNominal){
        //     updateInvoiceNominal(invoiceNominal);
        // })

        // Add new invoice fields dynamically
        document.getElementById('addButton').addEventListener('click', function() {
            const invoiceRowCount = document.getElementsByClassName('invoice-row').length;

            if (invoiceRowCount == 6) {
                alert('Maksimal invoice adalah 6');
                return;
            }

            const div = document.createElement('div');
            div.className = 'invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end mt-2';

            div.innerHTML = `
                <input type="hidden" name="trans_count[]" value="0" class="trans-count">
                <div class="flex-1">
                    <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Invoice <span class="required">*</span></label>
                    <input type="text" name="invoice[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice" required>
                </div>
                <div class="flex-1">
                    <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
                    <input type="number" name="nominal[]" readonly class="invoice-nominal bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" required>
                </div>
                <div class="flex-1">
                    <div class="flex gap-2">
                        <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeItem(this)">Delete</button>
                        <button type="button" id="addTrans" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900" >Add</button>
                    </div>
                </div>
            `;

            invoiceFieldsContainer.appendChild(div);

            div.querySelectorAll('.trans-nominal').forEach(function(transInput) {
                transInput.addEventListener('input', function() {
                    updateInvoiceNominal(div);
                });
            });
        });

        form.addEventListener('submit', function(event) {
            const invoiceRow = document.getElementsByClassName('invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end');
            const invoiceCount = invoiceRow.length;

            let hasInvalidRows = false;

            // Get all invoice-rows
            const invoiceRows = document.querySelectorAll('.invoice-row');

            invoiceRows.forEach(function(invoiceRow) {
                let hasTransRow = false;
                let nextSibling = invoiceRow.nextElementSibling;

                // Check if there are trans-rows following the invoice-row
                while (nextSibling) {
                    if (nextSibling.classList.contains('trans-row')) {
                        hasTransRow = true;
                        break;
                    } else if (nextSibling.classList.contains('invoice-row')) {
                        // If another invoice-row is found, stop checking
                        break;
                    }
                    nextSibling = nextSibling.nextElementSibling;
                }

                // If no trans-row is found for the current invoice-row, set flag
                if (!hasTransRow) {
                    hasInvalidRows = true;
                }
            });

            if (invoiceCount == 0) {
                alert('Inputkan minimal 1 invoice');
                event.preventDefault(); // Prevent the form from submitting
            }

            if (hasInvalidRows) {
                alert('Inputkan minimal 1 transaksi dalam 1 invoice');
                event.preventDefault(); // Prevent form submission
            }
        });
    });




    function addTransRow(invoiceRow) {
        const transDiv = document.createElement('div');
        transDiv.className = 'trans-row flex flex-col md:flex-row gap-4 mb-6 items-end mt-2 pl-8'; // Add padding-left for indentation

        transDiv.innerHTML = `
            <div class="flex-1">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan <span class="required">*</span></label>
                <input type="text" name="keterangan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Keterangan">
            </div>
            <div class="flex-1">
                <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
                <input type="number" name="trans_nominal[]" class="trans-nominal bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required placeholder="Nominal">
            </div>
            <div class="flex-1">
                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="removeTransRow(this)">Delete</button>
            </div>
        `;

        // Find the last trans-row after the invoiceRow
        let lastTransRow = invoiceRow;
        while (lastTransRow.nextElementSibling && lastTransRow.nextElementSibling.classList.contains('trans-row')) {
            lastTransRow = lastTransRow.nextElementSibling;
        }

        // Insert the new trans-row after the last trans-row
        lastTransRow.insertAdjacentElement('afterend', transDiv);

        // Increment trans_count
        const transCountInput = invoiceRow.querySelector('.trans-count');
        transCountInput.value = parseInt(transCountInput.value) + 1;
        console.log('Trans count after addition:', transCountInput.value);

        transDiv.querySelector('.trans-nominal').addEventListener('input', function() {
            updateInvoiceNominal(invoiceRow);
        });

        addEventListenersToTransNominals();
        synchronizeRows();
    }

    function addEventListenersToTransNominals() {
        const transNominals = document.querySelectorAll('.trans-nominal');
        transNominals.forEach(function(transInput) {
            transInput.removeEventListener('input', handleTransNominalInput);
            transInput.addEventListener('input', handleTransNominalInput);
        });
    }
    function handleTransNominalInput() {
        const transRow = this.closest('.trans-row');
        const invoiceRow = findInvoiceRow(transRow);
        if (invoiceRow) {
            updateInvoiceNominal(invoiceRow);
        }
    }

    function findInvoiceRow(transRow) {
        let previousElement = transRow.previousElementSibling;

        while (previousElement && !previousElement.classList.contains('invoice-row')) {
            previousElement = previousElement.previousElementSibling;
        }

        return previousElement ? previousElement : null;
    }

    function updateInvoiceNominal(invoiceRow) {
        let total = 0;
        let nextSibling = invoiceRow.nextElementSibling;

        // Sum all the nominal values in the associated trans-rows
        while (nextSibling && nextSibling.classList.contains('trans-row')) {
            const transNominal = nextSibling.querySelector('.trans-nominal').value;
            if (transNominal) {
                total += parseFloat(transNominal);
            }
            nextSibling = nextSibling.nextElementSibling;
        }

        // Update the nominal value in the invoice row
        invoiceRow.querySelector('.invoice-nominal').value = total > 0 ? total : null;
    }

    function removeTransRow(button) {
        const transRow = button.closest('.trans-row');
        if (transRow) {
            // Find the closest invoice-row that is before this trans-row
            let invoiceRow = transRow.previousElementSibling;
            while (invoiceRow && !invoiceRow.classList.contains('invoice-row')) {
                invoiceRow = invoiceRow.previousElementSibling;
            }

            if (invoiceRow) {
                const transCountInput = invoiceRow.querySelector('input[name="trans_count[]"]');

                // Decrease trans_count
                if (transCountInput) {
                    transCountInput.value = parseInt(transCountInput.value) - 1;
                } else {
                    console.log('trans_count[] input not found');
                }

                transRow.remove();

                // Update the nominal value for the invoice
                updateInvoiceNominal(invoiceRow);
            } else {
                console.log('invoice-row not found');
            }
        }
        synchronizeRows();
    }

    function removeItem(button) {
        const itemRow = button.closest('.invoice-row');
        const invoiceFieldsContainer = document.getElementById('invoiceFieldsContainer');

        if (itemRow) {
            let nextRow = itemRow.nextElementSibling;

            // Remove all associated trans-rows
            while (nextRow && nextRow.classList.contains('trans-row')) {
                nextRow.remove();
                nextRow = itemRow.nextElementSibling;
            }

            itemRow.remove();
        }


        synchronizeRows();
    }
</script>