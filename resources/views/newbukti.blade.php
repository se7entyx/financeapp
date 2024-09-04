<x-layout>
  @section('title', 'New Bukti Pengeluaran Kas')
  <style>
    .required {
      color: red;
    }
  </style>
  <x-slot:title>{{$title}}</x-slot:title>
  <section class="bg-white dark:bg-gray-900 w-full">
    @if (session('success'))
    <div class="alert alert-success">
      <script>
        alert("Bukti kas berhasil dibuat");
      </script>
    </div>
    @endif
    <div class="py-4 px-8 mx-auto max-w-7xl">
      <form id="my-form" action="/dashboard/new/bukti-pengeluaran" method="post">
        @csrf
        <div class="grid gap-x-8 gap-y-4 mb-6 lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1">
          <div class="col-span-1">
            <label for="nomer-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer <span class="required">*</span></label>
            <div class="flex space-x-2">
              <select id="dropdown-kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <option value="RMK" selected>RMK</option>
                <option value="DMK">DMK</option>
              </select>
              <select id="dropdown-bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <option value="I" selected>I</option>
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
              <select id="dropdown-tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                @php
                $startYear = date('Y');
                for ($i = 0; $i < 8; $i++) {
                  $year=$startYear + $i;
                  echo "<option value=\"$year\"".($i==0 ? ' selected' : '' ).">$year</option>";
                  }
                  @endphp
              </select>
            </div>
            <input type="hidden" id="nomer" name="nomer" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
          </div>
          <div class="col-span-1">
            <label for="dropdown-no-tanda-terima" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Tanda Terima <span class="required">*</span></label>
            <div class="relative">
              <input type="text" id="dropdown-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukan nomor tanda terima" autocomplete="off" required>
              <div id="dropdown-options" class="absolute left-0 right-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white z-10 hidden max-h-60 overflow-auto">
                @foreach($tandaTerimas as $tandaTerima)
                <div class="option p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600" data-value="{{ $tandaTerima->increment_id }}">{{ $tandaTerima->increment_id }}</div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-span-1">
            <label for="input-part3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dibayarkan kepada <span class="required">*</span></label>
            <input type="text" id="input-supplier" name="supplier-name" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Automatic Input" tanda-id readonly required>
            <input type="hidden" id="input-no-tanda-terima-hidden" name="tanda_terima_id_hidden" readonly required>
          </div>
          <div class="col-span-1">
            <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal jatuh tempo <span class="required">*</span></label>
            <div class="relative max-w-sm">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
              </div>
              <input id="datepicker-autohide-x" datepicker-format="dd-mm-yyyy" datepicker-autohide type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 cursor-not-allowed focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" placeholder="Automatic input" readonly required>
            </div>
          </div>
          <div class="col-span-1">
            <label for="input-part4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kas/Cheque/Bilyet Giro Bank <span class="required">*</span></label>
            <input type="text" id="input-bank" name="kas" value="Mandiri" class=" bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
          </div>
          <div class="col-span-1">
            <label for="berita_transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berita Transaksi <span class="required">*</span></label>
            <input type="text" id="berita_transaksi" name="berita_transaksi" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan berita" required>
          </div>
          <div class="col-span-1">
            <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. cek</label>
            <input type="text" id="number-input" name="no_cek" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan cek">
          </div>
          <div class="col-span-1">
            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukan keterangan">
          </div>
          <input type="hidden" name="jumlah" id="total-amount">
          <input type="hidden" id="ppnData" value="{{ json_encode($ppn) }}">
          <input type="hidden" id="pphData" value="{{ json_encode($pph) }}">
          <input type="hidden" id="bukti_data" name="bukti_data" value="">
          <div class="col-span-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="buktiTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="text-center w-1/7 px-6 py-3 border-gray-200 dark:border-gray-700">
                      No
                    </th>
                    <th scope="col" class="text-center w-3/7 px-6 py-3 border-gray-200 dark:border-gray-700">
                      Keterangan
                    </th>
                    <th scope="col" class="text-center w-2/7 px-6 py-3 border-gray-200 dark:border-gray-700">
                      Jumlah
                    </th>
                    <th scope="col" class="text-center w-1/7 px-6 py-3 border-gray-200 dark:border-gray-700">
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr class="font-semibold text-gray-900 dark:text-white">
                    <th scope="row" class="px-6 py-3 text-base w-1/7">Total</th>
                    <td class=" w-3/7"></td>
                    <td class="w-2/7"></td>
                    <td class="px-6 py-3 text-right w-1/7">0</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="col-start-4 flex justify-evenly">
            <button id="submit-btn" type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buktiTable = document.getElementById('buktiTable').getElementsByTagName('tbody')[0];
      let no = 1;
      bukti = [];
      const tandaTerimaInput = document.getElementById('dropdown-no-tanda-terima');
      const tandaTerimaHiddenInput = document.getElementById('input-no-tanda-terima-hidden');
      const supplier = document.getElementById('input-supplier');
      // let original = null;

      document.querySelectorAll('#dropdown-kode, #dropdown-bulan, #dropdown-tahun').forEach(input => {
        input.addEventListener('input', updateNomer);
      });

      function updateNomer() {
        const part1 = document.getElementById('dropdown-kode').value;
        const part2 = document.getElementById('dropdown-bulan').value;
        const part3 = document.getElementById('dropdown-tahun').value;
        const nomer = `${part1}/\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0/${part2}/${part3}`;
        document.getElementById('nomer').value = nomer;
        console.log(nomer);
      }

      const searchInput = document.getElementById('dropdown-search');
      const optionsContainer = document.getElementById('dropdown-options');
      const options = optionsContainer.getElementsByClassName('option');
      let isOptionClicked = false;

      searchInput.addEventListener('focus', function() {
        optionsContainer.classList.remove('hidden');
        filterOptions();
      });

      searchInput.addEventListener('input', function() {
        filterOptions();
      });

      searchInput.addEventListener('blur', function(event) {
        if (isOptionClicked) {
          event.preventDefault(); // Prevent blur if an option was clicked
          isOptionClicked = false; // Reset the flag
          return;
        }
        optionsContainer.classList.add('hidden');
        updateSupplierInfo(searchInput.value);
      });

      optionsContainer.addEventListener('mousedown', function(event) {
        if (event.target.classList.contains('option')) {
          isOptionClicked = true;
          searchInput.value = event.target.textContent;
          updateSupplierInfo(searchInput.value);
          optionsContainer.classList.add('hidden');
          searchInput.setCustomValidity('');
        }
      });

      function filterOptions() {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const text = option.textContent.toLowerCase();

          if (text.includes(filter)) {
            option.style.display = '';
          } else {
            option.style.display = 'none';
          }
        }
      }

      function updateSupplierInfo(id) {
        const tandaTerimaId = id;

        fetch(`/get-supplier-info/${tandaTerimaId}`) // Ensure the correct parameter name
          .then(response => response.json())
          .then(data => {
            if (data.supplier_name) {
              document.getElementById('input-no-tanda-terima-hidden').value = data.tanda_terima_id;
              supplier.value = data.supplier_name;

              // Update the datepicker field
              document.getElementById('datepicker-autohide-x').value = data.tanggal_jatuh_tempo;

              bukti = data.invoiceData.map(item => ({
                invoiceKeterangan: item.invoice_keterangan,
                transaction_id: item.transaction_id,
                transactionKeterangan: item.transaction_keterangan,
                nominalValue: item.transaction_nominal,
                selectedCurrency: item.currency,
                ppnid: item.id_ppn || null,
                ppnNominal: item.nominal_ppn || null,
                pphid: item.id_pph || null,
                pphNominal: item.nominal_pph || null,
                nominalSetelah: item.nomila_setelah || null
              }));
              console.log(bukti);
              renderTable();
            } else {
              console.log(data);
              alert('Tanda Terima not found');
              document.getElementById('datepicker-autohide-x').value = '';
              document.getElementById('input-no-tanda-terima-hidden').value = '';
              supplier.value = '';
              buktiTable.innerHTML = '';
              updateTotal();
            }
          })
          .catch(error => {
            alert('Tanda Terima not found');
            document.getElementById('datepicker-autohide-x').value = '';
            document.getElementById('input-no-tanda-terima-hidden').value = '';
            supplier.value = '';
            buktiTable.innerHTML = '';
            updateTotal();
          }).finally(() => {
            // Hide the loading animation
          });
      }

      // Restore the original value and update the hidden input on focus out
      // searchInput.addEventListener('focusout', updateSupplierInfo);

      // Function to format currency
      function formatCurrency(value, currency) {
        return `${currency} ${new Intl.NumberFormat('en-US').format(value)}`;
      }

      function updateTotal() {
        const rows = buktiTable.getElementsByTagName('tr');
        let total = 0;
        let currency = '';

        // Iterate through table rows to calculate total and determine currency
        for (let i = 0; i < rows.length; i++) {
          const cellAmount = rows[i].cells[2].textContent.trim();
          const parts = cellAmount.split(' ');
          if (parts.length === 2) {
            // Replace commas with nothing and periods with commas for numeric value parsing
            const numericValue = parseFloat(parts[1].replace(/,/g, '').replace(/\./g, '.'));
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

      function updateRowNumbers() {
        const rows = buktiTable.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
          const cell = rows[i].getElementsByTagName('td')[0];
          cell.textContent = i + 1;
        }
      }

      function renderTable() {
        // Clear existing rows in the table
        buktiTable.innerHTML = ''; // Clear all rows except for header

        // Keep track of the row index
        let rowIndex = 1;

        // Iterate through the bukti array
        bukti.forEach((item, index) => {
          const isFirstTransaction = index === 0 || bukti[index - 1].invoiceKeterangan !== item.invoiceKeterangan;

          // Add a new row for each transaction
          const newRow = buktiTable.insertRow();
          newRow.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";
          newRow.dataset.buktiIndex = index;

          if (isFirstTransaction) {
            const cellNo = newRow.insertCell(0);
            cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
            cellNo.textContent = rowIndex++;

            const cellKeterangan = newRow.insertCell(1);
            cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
            cellKeterangan.textContent = `${item.transactionKeterangan} (${item.invoiceKeterangan})`;

            const cellAmount = newRow.insertCell(2);
            cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
            cellAmount.textContent = formatCurrency(item.nominalValue, item.selectedCurrency);
          } else {
            // Handle subsequent transactions without index or invoice keterangan
            const cellNo = newRow.insertCell(0);
            cellNo.className = "px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border border-gray-200 dark:border-gray-700";
            cellNo.textContent = '';

            const cellKeterangan = newRow.insertCell(1);
            cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";
            cellKeterangan.textContent = item.transactionKeterangan;

            const cellAmount = newRow.insertCell(2);
            cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
            cellAmount.textContent = formatCurrency(item.nominalValue, item.selectedCurrency);
          }

          // Add "Add PPn" and "Add PPh" buttons in the "aksi" column
          const cellAksi = newRow.insertCell(3);
          cellAksi.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-center";

          const addPPnButton = document.createElement('button');
          // addPPhButton.className = 'ppnButton';
          addPPnButton.textContent = 'Add PPn';
          addPPnButton.className = 'ppnButton px-2 py-1 text-blue-500 text-xs rounded';
          addPPnButton.type = 'button';
          addPPnButton.onclick = () => {
            addTaxRow('PPn', item.nominalValue, item.selectedCurrency, newRow);
            addPPnButton.style.display = 'none'; // Hide other button
            updateTotal();
          }

          const addPPhButton = document.createElement('button');
          addPPhButton.textContent = 'Add PPh';
          addPPhButton.className = 'pphButton px-2 py-1 text-blue-500 text-xs rounded ml-2';
          addPPhButton.type = 'button';
          addPPhButton.onclick = () => {
            addTaxRow('PPh', item.nominalValue, item.selectedCurrency, newRow);
            addPPhButton.style.display = 'none'; // Hide button after click
            updateTotal(); // Set flag to indicate buttons have been used
          };

          cellAksi.appendChild(addPPnButton);
          cellAksi.appendChild(addPPhButton);
        });

        // Update the row numbers and total after rendering
        updateTotal();
      }

      function addTaxRow(type, baseAmount, currency, referenceRow) {
        // Fetch all tax rates from your data source
        const taxRates = getTaxRates(type);

        // Create a new row
        const newRow = buktiTable.insertRow(referenceRow.rowIndex);
        newRow.className = "bg-gray-100 border-b dark:bg-gray-900 dark:border-gray-700";

        // Empty cell for index
        const cellNo = newRow.insertCell(0);
        cellNo.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";

        // Cell for tax description with dropdown
        const cellKeterangan = newRow.insertCell(1);
        cellKeterangan.className = "px-6 py-4 border border-gray-200 dark:border-gray-700";

        const select = document.createElement('select');
        select.className = 'form-select';

        // Create dropdown options for tax rates
        taxRates.forEach(rate => {
          const option = document.createElement('option');
          option.value = rate.id; // Assuming each rate has a unique ID
          option.textContent = `${rate.name} (${rate.percentage}%)`; // Adjust according to your data
          select.appendChild(option);
        });

        // Initial tax amount set to 0
        const cellAmount = newRow.insertCell(2);
        cellAmount.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-right";
        cellAmount.textContent = formatCurrency(0, currency);

        // Update tax amount when a rate is selected
        select.addEventListener('change', (event) => {
          const selectedRateId = event.target.value;
          const selectedRate = taxRates.find(rate => rate.id === selectedRateId);
          if (selectedRate) {
            const taxAmount = calculateTaxAmount(baseAmount, selectedRate.percentage, type);
            cellAmount.textContent = formatCurrency(taxAmount, currency);

            const buktiIndex = referenceRow.dataset.buktiIndex;
            if (type === 'PPn') {
              bukti[buktiIndex].ppnid = selectedRate.id;
              bukti[buktiIndex].ppnNominal = taxAmount;
            } else if (type === 'PPh') {
              bukti[buktiIndex].pphid = selectedRate.id;
              bukti[buktiIndex].pphNominal = taxAmount;
            }
          }
          console.log(bukti);
          updateTotal();
        });

        cellKeterangan.appendChild(select);

        const selectedRate = taxRates.find(rate => rate.id);
        if (selectedRate) {
          const taxAmount = calculateTaxAmount(baseAmount, selectedRate.percentage, type);
          cellAmount.textContent = formatCurrency(taxAmount, currency);
          const buktiIndex = referenceRow.dataset.buktiIndex;
          if (type === 'PPn') {
            console.log(buktiIndex);
            bukti[buktiIndex].ppnid = selectedRate.id;
            bukti[buktiIndex].ppnNominal = taxAmount;
          } else if (type === 'PPh') {
            bukti[buktiIndex].pphid = selectedRate.id;
            bukti[buktiIndex].pphNominal = taxAmount;
          }
          console.log(bukti);
        }

        // Cell for actions (delete button)
        const cellAksi = newRow.insertCell(3);
        cellAksi.className = "px-6 py-4 border border-gray-200 dark:border-gray-700 text-center";

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'px-4 py-2 bg-red-500 text-white rounded';
        deleteButton.onclick = () => {
          newRow.remove();
          const buktiIndex = referenceRow.dataset.buktiIndex;
          if (taxRates.find(rate => rate.type === 'ppn')) {
            bukti[buktiIndex].ppnid = null;
            bukti[buktiIndex].ppnNominal = null;
            const addPPnButton = referenceRow.querySelector('button.ppnButton');
            addPPnButton.style.display = 'inline-block';
          } else if (taxRates.find(rate => rate.type === 'pph')) {
            bukti[buktiIndex].pphid = null;
            bukti[buktiIndex].pphNominal = null;
            const addPPhButton = referenceRow.querySelector('button.pphButton');
            addPPhButton.style.display = 'inline-block';
          }
          console.log(bukti);
          updateTotal();
        };

        cellAksi.appendChild(deleteButton);
      }


      function getTaxRates(type) {
        // Get tax data from hidden inputs
        const ppnData = JSON.parse(document.getElementById('ppnData').value);
        console.log(ppnData);
        const pphData = JSON.parse(document.getElementById('pphData').value);

        if (type === 'PPn') {
          return ppnData;
        } else if (type === 'PPh') {
          return pphData;
        }
        return [];
      }

      function calculateTaxAmount(baseAmount, rate, type) {
        let taxAmount;
        if (type === 'PPn') {
          taxAmount = baseAmount * (rate / 100);

        } else if (type === 'PPh') {
          taxAmount = -(baseAmount * (rate / 100));
        }
        taxAmount = Math.round(taxAmount);
        return taxAmount;
      }

      document.getElementById('my-form').addEventListener('submit', function(e) {
        const confirmSubmit = confirm('Are you sure you want to submit the form?');
        if (!confirmSubmit) {
          e.preventDefault(); // Prevent form submission if user cancels
          return;
        }
        const buktiJson = JSON.stringify(bukti);
        document.getElementById('bukti_data').value = buktiJson;
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

      updateNomer();
    });
  </script>
</x-layout>