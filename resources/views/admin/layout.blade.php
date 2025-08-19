<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: flex; }
        aside {
            width: 250px;
            background: #343a40;
            color: #fff;
        }
        aside a {
            display: block;
            padding: 10px 15px;
            color: #ddd;
            text-decoration: none;
        }
        aside a:hover, aside a.active {
            background: #495057;
            color: #fff;
        }
        main {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        header {
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Sidebar --}}
    @include('admin.partials.aside')

    {{-- Nội dung chính --}}
    <div class="d-flex flex-column flex-grow-1">
        @include('admin.partials.header')

        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
