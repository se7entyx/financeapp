<x-layout>
    @section('title', 'New Tanda Terima')
    <style>
        .required {
            color: red
        }
    </style>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900">
        @if (session('success'))
        <div class="alert alert-success">
            <script>
                alert("Tanda terima berhasil dibuat");
            </script>
        </div>
        @endif
        <div class="py-8 px-4 mx-auto max-w-7xl">
            <form id="addtandaterima" action="/dashboard/new/tanda-terima2" method="post">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier <span class="required">*</span></label>
                        <select id="supplier_id" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled selected>Select supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal <span class="required">*</span></label>
                        <input type="text" id="tanggal" name="tanggal" datepicker-format="dd-mm-yyyy" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">

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
                                    <input id="faktur-checkbox" name="faktur" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="true">
                                    <label for="faktur-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Faktur Pajak</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="po-checkbox" name="po" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="po-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">PO</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="bpb-checkbox" name="bpb" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="bpb-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">BPB</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input id="sjalan-checkbox" name="sjalan" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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
                                <option value="IDR" selected>IDR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div id="invoiceFieldsContainer">
                            <!-- Invoice fields will be appended here -->
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
                            <input id="datepicker-autohide" name="jatuh_tempo" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy" required type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
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
        console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        var invoiceCount = 0;
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
            month: '2-digit',
            year: 'numeric'
        }).replace(/\//g, '-');

        document.getElementById('tanggal').value = formattedDate;
        console.log("Formatted Date:", formattedDate);

        const addButton = document.getElementById('addButton');
        const invoiceFieldsContainer = document.getElementById('invoiceFieldsContainer');
        var form = document.getElementById('addtandaterima');
        let currentEditIndex = null;

        // Function to format currency
        function formatCurrency(value, currency) {
            return `${currency} ${new Intl.NumberFormat('id-ID').format(value)}`;
        }


        // Add new invoice fields dynamically
        addButton.addEventListener('click', function() {
            var invoiceRow = document.getElementsByClassName('invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end');
            var invoiceCount = invoiceRow.length;
            console.log(invoiceCount); // Decrement the invoice count after removing the item
            if (invoiceCount == 6) {
                alert('Maksimal invoice adalah 6');
                console.log(invoiceCount); // Decrement the invoice count after removing the item

                return;
            }
            invoiceCount++;
            console.log(invoiceCount); // Decrement the invoice count after removing the item

            const div = document.createElement('div');
            div.className = 'invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end mt-2'; // Flex container with responsive direction

            div.innerHTML = `
        <div class="flex-1">
            <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Invoice <span class="required">*</span></label>
            <input type="text" name="invoice[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice" required>
        </div>
        <div class="flex-1">
            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal <span class="required">*</span></label>
            <input type="number" name="nominal[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" required>
        </div>
        <div class="flex-1">
            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan <span class="required">*</span></label>
            <input type="text" name="keterangan[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal" required>
        </div>
        <div class="flex-1">
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
            invoiceCount--;
            console.log(invoiceCount); // Decrement the invoice count after removing the item
        }
    }

    document.getElementById('datepicker-autohide').addEventListener('change', function() {
        // Get the selected date value
        const selectedDate = this.value;

        // Convert the selected date to a Date object (assuming format dd-mm-yyyy)
        const [day, month, year] = selectedDate.split('-');
        const selectedDateObj = new Date(`${year}-${month}-${day}`);

        // Get today's date without time part
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Check if the selected date is valid and greater than today
        if (isNaN(selectedDateObj.getTime()) || selectedDateObj <= today) {
            alert('Please select a valid date greater than today.');
            // Clear the input field
            this.value = '';
        }
    });
</script>