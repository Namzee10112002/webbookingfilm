<header class="d-flex justify-content-between align-items-center">
    <h5>@yield('title')</h5>
    <div>
        <span>Xin chào, {{ Auth::user()->name ?? 'Admin' }}</span>
        <form action="{{ route('logout') }}" method="POST">@csrf
            <button class="btn btn-sm btn-outline-danger ms-3" type="submit">Đăng xuất</button>
        </form>
    </div>
</header>