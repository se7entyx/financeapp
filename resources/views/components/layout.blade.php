    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.5.2-web/css/all.min.css')}}">
</head>

<body class="h-full flex">
    <x-sidebar></x-sidebar> 
    <div class="flex-grow flex items-center justify-center ml-64">
        <main class="w-full">
            <x-header> {{$title}} </x-header>
            {{$slot}}
        </main>
    </div>
</body>

</html>
