<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RuangBaca - Perpustakaan Digital')</title>

    <!-- Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo 600
                        secondary: '#10B981', // Emerald 500
                        dark: '#1F2937',
                    }
                }
            }
        }
    </script>
    
    <!-- Tambahan CSS Khusus jika ada -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Konten Utama akan dimasukkan ke sini -->
    <main class="flex-grow flex">
        @yield('content')
    </main>

    <!-- Tambahan Script Khusus jika ada -->
    @stack('scripts')
</body>
</html>