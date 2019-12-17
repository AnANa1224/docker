<?php


namespace App\Http\Controllers;


use App\Services\OrderServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected function find(Request $request)
    {
        $result = (new OrderServer())->find($request->input());
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '获取失败',
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

    public function create(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'user_id' => 'required|integer',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute为必填项',
                'string' => ':attribute类型为字符串',
                'integer' => ':attribute类型为整数',
                'min' => ':attribute不符合最小要求',
                'max' => ':attribute超出最大限制',
            ], [
                'product_id' => '商品id',
                'user_id' => '商品id',
                'status' => '状态',
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
        $result = (new OrderServer())->create($request->input());
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '已售空',
                'data' => null,
            ]);
        } else if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '下单失败',
                'data' => null,
            ]);
        }
        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '下单成功',
            'data' => $result,
        ]);
    }

    public function add(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'user_id' => 'required|integer',
                'status' => 'required|integer|min:1|max:3',
                'order' => 'required|string',
            ], [
                'required' => ':attribute为必填项',
                'string' => ':attribute类型为字符串',
                'integer' => ':attribute类型为整数',
                'min' => ':attribute不符合最小要求',
                'max' => ':attribute超出最大限制',
            ], [
                'product_id' => '商品id',
                'user_id' => '商品id',
                'status' => '状态',
                'order' => '订单号',
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
        $result = (new OrderServer())->add($request->input());
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '支付失败',
                'data' => null,
            ]);
        }
        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '支付成功',
            'data' => $result,
        ]);
    }

    public  function cancel(Request $request)
    {
        $result = (new OrderServer())->cancel($request->input());
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '取消订单失败',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '取消订单成功',
            'data' => $result,
        ]);
    }

    public function delete(Request $request)
    {
        $result = (new OrderServer())->delete($request->id);
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '删除订单失败',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '删除订单成功',
            'data' => $result,
        ]);
    }
}
