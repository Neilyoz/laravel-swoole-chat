<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userInfo(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }

    public function update(UserRequest $request)
    {
        $request->validated();

        $formData = $request->only(['name', 'email', 'password', 'head_pic']);

        // 过滤null值
        $formData = array_filter($formData, function ($item) {
            return $item !== null;
        });

        if (!empty($formData['password'])) {
            $formData['password'] = Hash::make($formData['password']);
        }

        $user = $request->user();

        $user->update($formData);

        return response()->json(['success' => true, 'data' => $formData]);
    }
}
