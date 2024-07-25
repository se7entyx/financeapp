<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-7xl">
            <form id="addtandaterima" action="/dashboard/new/tanda-terima2" method="post">
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
                        <input type="text" id="tanggal" datepicker-format="dd-mm-yyyy" datepicker name="tanggal" aria-label="disabled date input" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <label for="invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>
                        <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 mx-3 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 mt-3 items-center justify-center" id="addButton">Add</button>
                        <div id="invoiceFieldsContainer">
                            <!-- Invoice fields will be appended here -->
                        </div>
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
                        <button type="submit" id="submitform" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
    </section>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

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
            div.className = 'invoice-row flex flex-col md:flex-row gap-4 mb-6 items-end'; // Flex container with responsive direction

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
