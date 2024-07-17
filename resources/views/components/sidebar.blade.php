<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 flex-shrink-0" aria-label="Sidenav">
    <div class="flex flex-col overflow-y-auto py-5 px-3 h-full bg-gray-800 border-gray-700">
        <ul class="space-y-2">
            <li>
                <a href="/profile" class="flex items-center p-2 text-base font-normal rounded-lg text-white  hover:bg-gray-700 group">
                    <i class="fa-solid fa-user"></i>
                    <span class="ml-3">Profile</span>
                </a>
            </li>
        </ul>
        <ul class="pt-5 mt-5 space-y-2 border-t  border-gray-700">
            <li>
                <a href="/dashboard/new" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-10 py-3 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-pencil"></i>
                    <span class="ml-2">Tulis</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center p-2 w-full text-base font-normal  rounded-lg transition duration-75 group  text-white hover:bg-gray-700" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <i class="fa-solid fa-file"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Docs</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                    <li>
                        <a href="/dashboard/all" class="flex items-center p-2 pl-11 w-full text-base font-normal  rounded-lg transition duration-75 group  text-white hover:bg-gray-700">All Documents</a>
                    </li>
                    <li>
                        <a href="/dashboard/my" class="flex items-center p-2 pl-11 w-full text-base font-normal  rounded-lg transition duration-75 group  text-white hover:bg-gray-700">My Documents</a>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center p-2 w-full text-base font-normal  rounded-lg transition duration-75 group  text-white hover:bg-gray-700" aria-controls="dropdown-pages2" data-collapse-toggle="dropdown-pages2">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Admin</span>
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </button>
                <ul id="dropdown-pages2" class="hidden py-2 space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal  rounded-lg transition duration-75 group text-white hover:bg-gray-700">User</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-normal rounded-lg transition duration-75 group text-white hover:bg-gray-700">Doc</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="mt-auto space-y-2">
            <li>
                <button type="submit" class="flex items-center p-2 text-base w-full font-normal rounded-lg text-white  hover:bg-gray-700 group">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    <span class="ml-3">Logout</span>
                </button>
            </li>
        </ul>
    </div>
</aside>