<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
       $form = $request->get('form', 'login');
        return view('user.pages.auth', compact('form'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email'    => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min'   => 'Mật khẩu phải ít nhất 6 ký tự',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('activeForm', 'login');
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng')->with('activeForm', 'login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits:10',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'  => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email'    => 'Email không đúng định dạng',
            'email.unique'   => 'Email đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.digits'   => 'Số điện thoại phải đủ 10 số',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min'   => 'Mật khẩu phải ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('activeForm', 'register');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 0,
            'status'   => 1,
        ]);

        return redirect()->route('auth')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập')->with('activeForm', 'login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Bạn đã đăng xuất');
    }
}
