<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ - Đặt vé xem phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .movie-slide img { height: 350px; object-fit: cover; }
        .partner-logos img { height: 40px; margin: 0 10px; }
        footer { background: #222; color: #fff; padding: 20px 0; }
        footer a { color: #bbb; text-decoration: none; }
        footer a:hover { color: #fff; }
    </style>
    @stack('styles')
</head>
<body>

    @include('user.partials.header')

    <main>
        @yield('content')
    </main>

    @include('user.partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
