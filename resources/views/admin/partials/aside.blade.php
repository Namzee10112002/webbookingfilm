<style>
aside a { display:block; padding:8px 15px; text-decoration:none; color:white; }
aside .submenu { display:none; padding-left:20px; }
aside .has-submenu:hover .submenu { display:block; }
</style>

<aside>
    <h4 class="p-3">🎬 Admin Panel</h4>
    <a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Trang chủ</a>
    <a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Quản lý người dùng</a>
    <a href="{{ route('admin.cities.index') }}"><i class="fa fa-city"></i> Quản lý thành phố</a>
    <a href="{{ route('admin.companies.index') }}"><i class="fa fa-building"></i> Quản lý hãng rạp</a>
    <a href="{{ route('admin.movies.index') }}"><i class="fa fa-film"></i> Quản lý phim</a>

    <div class="has-submenu">
    <a href="#"><i class="fa fa-ticket"></i> Quản lý đơn hàng ▾</a>
    <div class="submenu">
        <a href="{{ route('admin.choose.company') }}"><i class="fa fa-building"></i> Theo hãng rạp</a>
        <a href="{{ route('admin.choose.theater') }}"><i class="fa fa-store"></i> Theo rạp</a>
        <a href="{{ route('admin.choose.movie') }}"><i class="fa fa-film"></i> Theo phim</a>
    </div>
</div>


    <a href="{{ route('admin.reports.index') }}"><i class="fa fa-chart-line"></i> Báo cáo thống kê</a>
</aside>
