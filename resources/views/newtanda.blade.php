<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl">
            <form id="addtandaterima" action="/dashboard/new/tanda-terima" method="post">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled selected>Select supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                        <input type="text" id="tanggal" name="tanggal" aria-label="disabled date input" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1 lg:col-span-2">
                        <label for="Lampiran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lampiran</label>
                        <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input type="hidden" name="faktur" value="false">
                                    <input id="faktur-checkbox" name="faktur" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="true">
                                    <label for="faktur-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Faktur Pajak</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input type="hidden" name="po" value="false">
                                    <input id="po-checkbox" name="po" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="po-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">PO</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                    <input type="hidden" name="bpb" value="false">
                                    <input id="bpb-checkbox" name="bpb"  value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="bpb-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">BPB</label>
                                </div>
                            </li>
                            <li class="border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center px-3 py-2">
                                <input type="hidden" name="sjalan" value="false">
                                    <input id="sjalan-checkbox" name="sjalan" value="true" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="sjalan-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Surat Jalan</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-3 justify-center items-center">
                        <form method="POST" name="addinvoice" id="addinvoice">
                            <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>
                            <div class="flex items-center py-2">
                                <div class="mb-4" id="textFieldno" style="display: block;">
                                    <label for="notextField" class="block text-sm font-medium text-gray-700 dark:text-gray-300">No</label>
                                    <input type="text" id="notextField" name="noinvoiceinput" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div class="px-3 mb-4" id="textFieldnominal" style="display: block;">
                                    <label for="currency-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nominal</label>
                                    <div class="flex">
                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 1 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                                </svg>
                                            </div>
                                            <input type="number" id="currency-input" class="block w-full p-2.5 pl-10 text-sm text-gray-900 bg-gray-50 rounded-l-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="" min="0" />
                                        </div>
                                        <button id="dropdown-currency-button" data-dropdown-toggle="dropdown-currency" class="inline-flex items-center py-2.5 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-r-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                            IDR
                                        </button>
                                        <div id="dropdown-currency" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-36 dark:bg-gray-700">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-currency-button">
                                                <li>
                                                    <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" data-currency="IDR">
                                                        <div class="inline-flex items-center">
                                                            IDR
                                                        </div>
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" data-currency="USD">
                                                        <div class="inline-flex items-center">
                                                            USD
                                                        </div>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 mx-3 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 mt-3 items-center justify-center" id="addButton">Add</button>
                            </div>
                            <div class="col-span-3">
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700" id="invoiceTable">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 border border-gray-200 dark:border-gray-700">
                                                    No
                                                </th>
                                                <th scope="col" class="px-6 py-3 border border-gray-200 dark:border-gray-700">
                                                    No Invoice
                                                </th>
                                                <th scope="col" class="px-6 py-3 border border-gray-200 dark:border-gray-700">
                                                    Nominal
                                                </th>
                                                <th scope="col" class="px-6 py-3 border border-gray-200 dark:border-gray-700">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="sm:col-span-2 md:col-span-1 lg:col-span-2">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Jatuh Tempo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" name="jatuh_tempo" datepicker datepicker-autohide datepicker-format="dd-mm-yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-span-3">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                    </div>
                    <div class="sm:col-span-4 md:col-span-1 lg:col-span-4 flex justify-center">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Submit
                        </button>
                        <button type="" class="inline-flex ml-4 items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Preview
                        </button>
                    </div>
            </form>
        </div>
        <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-modal" disabled>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" id="edit-form">
                        <div class="grid gap-4 mb-4 grid-cols-1">
                            <div>
                                <label for="editnotextfield" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Invoice</label>
                                <input type="text" name="editnoinvoice" id="editnotextfield" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="">
                            </div>
                            <div>
                                <label for="currency-input2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal</label>
                                <div class="flex">
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 1 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                            </svg>
                                        </div>
                                        <input type="number" id="currency-input2" class="block w-full p-2.5 pl-10 text-sm text-gray-900 bg-gray-50 rounded-l-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="" min="0">
                                    </div>
                                    <button id="dropdown-currency-button2" data-dropdown-toggle="dropdown-currency2" class="inline-flex items-center py-2.5 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-r-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                        IDR
                                    </button>
                                    <div id="dropdown-currency2" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-36 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-currency-button2">
                                            <li>
                                                <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem2" data-currency2="IDR">
                                                    <div class="inline-flex items-center">
                                                        IDR
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem2" data-currency2="USD">
                                                    <div class="inline-flex items-center">
                                                        USD
                                                    </div>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-toggle="edit-modal">Cancel</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800" id="save-edit-button">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </form>
        </div>
        </div>
    </section>
</x-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current date and time
        const now = new Date();
        const formattedDate = now.toLocaleString('en-US', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        document.getElementById('tanggal').value = formattedDate;

        const dropdownButton = document.getElementById('dropdown-currency-button');
        const dropdownMenu = document.getElementById('dropdown-currency');
        const menuItems = dropdownMenu.querySelectorAll('button[data-currency]');
        const dropdownButton2 = document.getElementById('dropdown-currency-button2');
        const dropdownMenu2 = document.getElementById('dropdown-currency2');
        const menuItems2 = dropdownMenu2.querySelectorAll('button[data-currency2]');
        const addButton = document.getElementById('addButton');
        const invoiceTable = document.getElementById('invoiceTable').getElementsByTagName('tbody')[0];
        let no = 1;
        const invoices = [];
        let currentEditRow = null; // Track the row being edited

        // Function to toggle dropdown visibility
        function toggleDropdown(dropdownMenu) {
            dropdownMenu.classList.toggle('hidden');
            dropdownMenu.classList.toggle('block');
        }

        // Function to format currency
        function formatCurrency(value, currency) {
            return `${currency} ${new Intl.NumberFormat('id-ID').format(value)}`;
        }

        // Set default value
        dropdownButton.textContent = 'IDR';
        dropdownButton2.textContent = 'IDR';

        // Event listeners for the menu items
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                const selectedCurrency = this.getAttribute('data-currency');
                dropdownButton.textContent = selectedCurrency;
                toggleDropdown(dropdownMenu);
            });
        });

        menuItems2.forEach(item => {
            item.addEventListener('click', function() {
                const selectedCurrency2 = this.getAttribute('data-currency2');
                dropdownButton2.textContent = selectedCurrency2;
                toggleDropdown(dropdownMenu2);
            });
        });

        // Function to update row numbers
        function updateRowNumbers() {
            const rows = invoiceTable.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].getElementsByTagName('td')[0];
                cell.textContent = i + 1;
            }
        }

        // Function to handle edit modal
        function openEditModal(rowIndex) {
            currentEditRow = invoiceTable.rows[rowIndex];
            const invoiceNo = invoices[rowIndex].invoiceNo;
            const nominalValue = invoices[rowIndex].amount; // Extract value, assuming formatCurrency is used
            const currency = invoices[rowIndex].currency; // Extract currency

            document.getElementById('editnotextfield').value = invoiceNo;
            document.getElementById('currency-input2').value = nominalValue;
            dropdownButton2.textContent = currency; // Set dropdown to the current currency

            // Show the modal
            const editModal = document.getElementById('edit-modal');
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }

        function closeModal(modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        const cancelButton = document.querySelector('[data-modal-toggle="edit-modal"]');
        cancelButton.addEventListener('click', function() {
            closeModal(document.getElementById('edit-modal'));
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const editedInvoiceNo = document.getElementById('editnotextfield').value;
            const editedNominalValue = document.getElementById('currency-input2').value;
            const editedCurrency = dropdownButton2.textContent;

            // Update the table row
            currentEditRow.cells[1].textContent = editedInvoiceNo;
            currentEditRow.cells[2].textContent = formatCurrency(editedNominalValue, editedCurrency);

            // Close modal
            closeModal(document.getElementById('edit-modal'));
        });

        // Save edited data
        function saveEdit() {
            if (currentEditRow) {
                const noInvoice = document.getElementById('editnotextfield').value;
                const nominalValue = document.getElementById('currency-input2').value;
                const selectedCurrency = dropdownButton2.textContent;
                const formattedNominal = formatCurrency(nominalValue, selectedCurrency);

                // Update the row data in the table
                currentEditRow.cells[1].textContent = noInvoice;
                currentEditRow.cells[2].textContent = formattedNominal;

                // Update the invoice array
                const rowIndex = currentEditRow.rowIndex - 1;
                invoices[rowIndex] = {
                    invoiceNo: noInvoice,
                    amount: nominalValue,
                    currency: selectedCurrency
                };

                console.log('Invoices after edit:', invoices); // Log the array to the console for verification

                // Hide the modal
                const modal = document.getElementById('edit-modal');
                modal.classList.add('hidden');

                currentEditRow = null; // Clear the current row being edited
            }
        }

        // Event listener for the add button
        addButton.addEventListener('click', function() {
            const invoiceNo = document.getElementById('notextField').value;
            const nominalValue = document.getElementById('currency-input').value;
            const selectedCurrency = dropdownButton.textContent;

            if (invoiceNo && nominalValue) {
                const newRow = invoiceTable.insertRow();
                newRow.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";

                const cellNo = newRow.insertCell(0);
                cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
                cellNo.textContent = no++;

                const cellInvoice = newRow.insertCell(1);
                cellInvoice.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                cellInvoice.textContent = invoiceNo;

                const cellHarga = newRow.insertCell(2);
                cellHarga.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                cellHarga.textContent = formatCurrency(nominalValue, selectedCurrency);

                const cellAction = newRow.insertCell(3);
                cellAction.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
                cellAction.innerHTML = '<button class="font-medium text-blue-600 dark:text-blue-500 hover:underline editButton" data-modal-target="edit-modal" data-modal-toggle="edit-modal">Edit</button> <button class="font-medium text-red-600 dark:text-red-500 hover:underline deleteButton">Delete</button>';

                // Store the invoice data in the array
                invoices.push({
                    invoiceNo: invoiceNo,
                    amount: nominalValue,
                    currency: selectedCurrency
                });

                console.log('Invoices:', invoices); // Log the array to the console for verification

                // Clear inputs
                document.getElementById('notextField').value = '';
                document.getElementById('currency-input').value = '';

                // Add event listener for the delete button
                const deleteButton = newRow.querySelector('.deleteButton');
                deleteButton.addEventListener('click', function() {
                    const rowIndex = newRow.rowIndex - 1; // Get the index of the row
                    invoices.splice(rowIndex, 1); // Remove the corresponding invoice from the array
                    invoiceTable.deleteRow(rowIndex); // Remove the row from the table
                    console.log('Invoices after deletion:', invoices); // Log the array to the console for verification
                    updateRowNumbers(); // Update the row numbers
                });

                // Add event listener for the edit button
                const editButton = newRow.querySelector('.editButton');
                editButton.addEventListener('click', function() {
                    openEditModal(newRow.rowIndex - 1); // Pass the row index to the function
                });

                updateRowNumbers(); // Update the row numbers after adding a new row
            }
        });

        // Event listener to close the modal
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById(button.getAttribute('data-modal-toggle'));
                modal.classList.toggle('hidden');
            });
        });

        // Handle save edit button
        document.getElementById('save-edit-button').addEventListener('click', function() {
            saveEdit();
        });
    });
</script>