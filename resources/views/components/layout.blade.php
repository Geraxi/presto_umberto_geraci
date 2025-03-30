<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <x-navbar />
    
    <main class="flex-grow-1">
        @if(session()->has('message'))
            <div class="alert alert-success text-center">
                {{ session('message') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>