<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login Sistem' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-slate-100 font-['Plus Jakarta Sans',sans-serif] text-gray-900 antialiased">

    {{ $slot }}

    <script src="https://unpkg.com/lucide@latest"></script>
</body>

</html>