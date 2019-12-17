<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'required' => ':attribute不能为空',
            'integer' => ':attribute格式不正确'
        ], [
            'id' => '商品id',
        ]);
        if ($validator->fails()) {
            /* dd($validator->errors()->first());
            return $validator->errors()->first();*/
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => null,
            ]);
        }
        // 查询
        $result = (new ProductServer())->findPro($request->id);
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'data' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $result = (new ProductServer())->createPro($request->input());
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '添加失败',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '添加成功',
            'data' => $result,
        ]);
    }
}
