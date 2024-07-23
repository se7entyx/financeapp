<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <div class="bg-white shadow-md rounded p-6 max-w-md w-full">
        <!-- <h2 class="text-2xl font-bold mb-4">Profile Information</h2> -->
        <div class="mb-4">
            <label class="block text-gray-700 text-md font-bold mb-2" for="name">Name:</label>
            <p id="name" class="text-gray-900 text-md">{{Auth::user()->name}}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-md font-bold mb-2" for="email">Email:</label>
            <p id="email" class="text-gray-900 text-md">{{Auth::user()->email}}</p>
        </div>
        <button class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="openModal()">Change Password</button>
    </div>

    <div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Change Password</h2>
            <form id="changePasswordForm" method="post" action="/profile" onsubmit="return validatePassword()">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                    <button type="button" class="text-gray-500 px-4 py-2 rounded" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>



        <script>
            function openModal() {
                document.getElementById('passwordModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('passwordModal').classList.add('hidden');
            }

            function validatePassword() {
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                const currentPassword = document.getElementById('current_password').value;

                if (newPassword !== confirmPassword) {
                    alert('New Password and Confirm New Password do not match');
                    return false;
                }
                return true;
            }
        </script>
</x-layout>