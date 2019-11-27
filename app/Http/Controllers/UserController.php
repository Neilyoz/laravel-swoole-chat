<?php

namespace App\Http\Controllers;

use App\Friend;
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

    private function isRelationExtsis($ownerUser, $relationUser)
    {
        $relationInfo = Friend::where([
            'owner_id' => $ownerUser->id,
            'relation_id' => $relationUser->id
            ])->first();

        if ($relationInfo) {
            abort(400, '已经添加过好友');
        }
    }

    public function addFriend(Request $request)
    {
        $relationUser = User::where('email', trim($request->email))->first();

        if (!$relationUser) {
            abort(400, '用户不存在');
        }

        $ownerUser = $request->user();

        $this->isRelationExtsis($ownerUser, $relationUser);

        Friend::create([
            'owner_id' => $ownerUser->id,
            'relation_id' => $relationUser->id
        ]);

        // 方便演示 自动互粉
        Friend::create([
            'owner_id' => $relationUser->id,
            'relation_id' => $ownerUser->id
        ]);

        return response()->json(['success' => true]);
    }

    // 获取好友列表
    public function friendList(Request $request)
    {
        $user = $request->user();

        return response()->json($user->friends);
    }
}
