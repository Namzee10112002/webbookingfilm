<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">🎬 MovieBooking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('companies.index') }}">Rạp phim</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('ticket.lookup') }}">Tra cứu vé</a></li>
            </ul>

            <ul class="navbar-nav">
                @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('auth', ['form' => 'login']) }}">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('auth', ['form' => 'register']) }}">Đăng ký</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.tickets') }}">Quản lý vé của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Quản lý thông tin</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button class="dropdown-item" type="submit">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
