<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            abort(400, '请选择要上传的文件');
        }

        $picture = $request->file('file');

        if (!$picture->isValid()) {
            abort(404, '无效上传文件');
        }

        // 扩展名获取
        $extension = $picture->getClientOriginalExtension();

        $fileName = $picture->getClientOriginalName();

        // 新文件名生成
        $newFileName = md5($fileName . time() . mt_rand(1, 10000)) . '.' . $extension;

        if ($picture->move('img', $newFileName)) {
            return response()->json(['path' => '/img/' . $newFileName]);
        }

        abort(500, '文件上传错误');
    }
}
