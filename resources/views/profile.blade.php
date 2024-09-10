<x-layout>
    @section('title', 'Profile')
    <x-slot:title>{{$title}}</x-slot:title>
    @if (session('status'))
    <div class="alert alert-success">
        <script>
            alert("Password sudah terganti");
        </script>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <script>
            alert("Password tidak sama");
        </script>
    </div>
    @endif
    <div class="bg-white shadow-md rounded p-6 max-w-md w-full">
        <!-- <h2 class="text-2xl font-bold mb-4">Profile Information</h2> -->
        <div class="mb-4">
            <label class="block text-gray-700 text-md font-bold mb-2" for="name">Name:</label>
            <p id="name" class="text-gray-900 text-md">{{Auth::user()->name}}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-md font-bold mb-2" for="email">Username:</label>
            <p id="email" class="text-gray-900 text-md">{{Auth::user()->username}}</p>
        </div>
        <button class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="openModal()">Change Password</button>
    </div>

    <div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Change Password</h2>
            <form id="changePasswordForm" method="post" action="{{route('changePassword')}}" onsubmit="return validatePassword()">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" minlength="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
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
        </script>
</x-layout>