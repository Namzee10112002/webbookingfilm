<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\MovieLike;
use App\Models\MovieComment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 0)
            ->withCount([
                'likes as total_likes',
                'comments as total_comments'
            ])
            ->get()
            ->map(function ($user) {
                $user->total_spent = Order::where('user_id', $user->id)
                    ->where('status_order', 0) // chỉ đơn đã thanh toán
                    ->sum('total_order');
                return $user;
            });

        return view('admin.pages.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status == 0 ? 1 : 0; // 0 = hoạt động, 1 = khóa
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }
}

