<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/regular.min.css') }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
</head>
<body>
    <main class="flex flex-col min-w-screen p-8 gap-4 text-gray-500">
        {{ $slot }}
    </main>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>