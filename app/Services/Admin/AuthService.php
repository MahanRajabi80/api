<?php

namespace App\Services\Admin;


use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use ApiResponse;

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user->role == 'user') {
            return $this->forbiddenResponse('', 'شما به این صفحه دسترسی ندارید.', true);
        }

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return $this->unauthorizedResponse('', 'کلمه عبور یا نام کاربری صحیح نمی باشد.', true);
        }

        $user = Auth::user();
        $res = [
            'user' => $user,
            'token' => $token
        ];
        return $this->okResponse($res);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->createdResponse($user, 'کاربر با موقیت ذخیره شد', true);
    }

    public function logout()
    {
        Auth::logout();
        return $this->noContentResponse('کاربر با موقیت خارج شد.', true);
    }

    public function refresh()
    {
        $res = [
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];

        return $this->okResponse($res);
    }

    public function me()
    {
        $user = Auth::user();
        return $this->okResponse($user);
    }
}
