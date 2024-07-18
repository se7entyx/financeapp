<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl">
            <form action="#">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <div>
                            <label for="supplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                            <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Select supplier</option>
                                <option value="a">Master Supplier A</option>
                                <option value="b">Master Supplier B</option>
                                <option value="c">Master Supplier C</option>
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                        <form class="max-w-sm mx-auto">
                            <input type="text" id="disabled-date-input" aria-label="disabled date input" class="mb-5 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        </form>
                    </div>
                    <div class="sm:col-span-2">
                        
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        Add product
                    </button>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the current date and time
            const now = new Date();

            // Set the value of the disabled input field
            const formattedDate = now.toLocaleString('en-US', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            const disabledDateInput = document.getElementById('disabled-date-input');
            disabledDateInput.value = formattedDate;
        });
    </script>
</x-layout>