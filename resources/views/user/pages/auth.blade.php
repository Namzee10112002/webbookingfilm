@extends('user.layout')

@section('title', 'Đăng nhập / Đăng ký')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Thông báo --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form login --}}
            <div id="loginForm" style="display: {{ $form === 'register' ? 'none' : 'block' }};">
                <h3 class="mb-4">Đăng nhập</h3>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    <p class="mt-3 text-center">
                        Bạn chưa có tài khoản? <a href="#" id="showRegister">Đăng ký ngay</a>
                    </p>
                </form>
            </div>

            {{-- Form register --}}
            <div id="registerForm" style="display: {{ $form === 'register' ? 'block' : 'none' }};">
                <h3 class="mb-4">Đăng ký</h3>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Họ tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Đăng ký</button>
                    <p class="mt-3 text-center">
                        Bạn đã có tài khoản? <a href="#" id="showLogin">Đăng nhập</a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $('#showRegister').click(function(e){
            e.preventDefault();
            $('#loginForm').fadeOut(200, function(){
                $('#registerForm').fadeIn(200);
            });
        });

        $('#showLogin').click(function(e){
            e.preventDefault();
            $('#registerForm').fadeOut(200, function(){
                $('#loginForm').fadeIn(200);
            });
        });
    });
</script>
@endpush
@endsection
