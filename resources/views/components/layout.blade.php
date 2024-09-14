<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <title>@yield('title', 'Default Title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	<!-- <link rel="stylesheet" href="{{ asset('build/assets/app-BRbn0B88.css') }}"> -->
	<!-- <script src="{{ asset('/public/build/assets/app-Bra6MsPr.js')}}"></script> -->
    <!-- <link rel="stylesheet" href="{{ asset('public/fontawesome-free-6.5.2-web/css/all.min.css') }}"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	<!-- <link rel="stylesheet" href="{{ asset('resources/js/app.js')}}"> -->
	<!-- <link rel="stylesheet" href="{{ asset('resources/css/app.css')}}"> -->
	

	
    <style>
        /* Prevent horizontal overflow */
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body class="h-full flex overflow-x-hidden">
    <!-- Sidebar Component -->
    <x-sidebar></x-sidebar>

    <div class="flex-grow flex flex-col sm:ml-64 overflow-x-hidden">
        <!-- Header Component -->
        <x-header>{{ $title }}</x-header>

        <main class="w-full flex justify-center sm:justify-start items-center sm:items-start">
            {{ $slot }}
        </main>
    </div>
   <!-- <script src="../path/to/flowbite/dist/flowbite.min.js"></script> -->
 
</body>

</html>
