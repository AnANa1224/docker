<?php

namespace App\Http\Controllers\ProductApi;

use App\Http\Controllers\Controller;
use App\Services\NavService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NavController extends Controller
{
    /**
     * 查询某一类所有导航信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'type_id' => 'nullable|integer|min:1|max:4',
            'page' => 'nullable|integer',
        ], [
            'integer' => ':attribute格式不正确',
            'min' => ':attribute超出限制',
            'max' => ':attribute超出限制',
        ], [
            'type_id' => '类型id',
            'page' => '分页',
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
        $request->page ? $page = $request->page : $page = 1;
        $request->type_id ? $type = $request->type_id : $type = 1;
        // 查询
        $result = (new NavService())->show($type, $page);
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
            'data' => $result['data'],
            'page' => $result['page'],
        ]);
    }

    /**
     * 查询单条数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
        ], [
            'required' => ':attribute不为空',
            'integer' => ':attribute格式不正确',
            'min' => ':attribute不在范围之内',
        ], [
            'id' => 'id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => null,
            ]);
        }
        // 查询
        $result = (new NavService())->find($request->id);
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '获取失败',
                'data' => null,
            ]);
        }
        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'data' => $result,
        ]);
    }

    /**
     * 新增一条导航数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|integer|min:1|max:4',
            'title' => 'required|string|max:30',
            'picture' => 'required|string',
            'link_type' => 'required|integer|min:1|max:4',
            'link_target' => 'required|integer|min:1|max:1000',
            'sort' => 'integer|min:0|max:10',
            'status' => 'required|integer|min:1|max:3',
        ], [
            'required' => ':attribute为必填项',
            'string' => ':attribute类型错误',
            'integer' => ':attribute类型错误',
            'min' => ':attribute不符合要求',
            'max' => ':attribute超出限制',
            'JSON' => ':attribute格式错误',
        ], [
            'type_id' => '导航类型',
            'title' => '导航标题',
            'picture' => '图片信息',
            'link_type' => '链接类型',
            'link_target' => '链接目标',
            'sort' => '排序',
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
        // 保存
        $result = (new NavService())->create($request->input());

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '添加失败,已有相同类型的标题',
                'data' => null,
            ]);
        } else if (!$result) {
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
            'data' => null,
        ]);

    }

    /**
     * 修改导航信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|integer|min:1|max:4',
            'title' => 'required|string|max:30',
            'picture' => 'required|string',
            'link_type' => 'required|integer|min:1|max:4',
            'link_target' => 'required|integer|min:1|max:1000',
            'sort' => 'integer|min:0|max:10',
            'status' => 'required|integer|min:1|max:3',
        ], [
            'required' => ':attribute为必填项',
            'string' => ':attribute类型错误',
            'integer' => ':attribute类型错误',
            'min' => ':attribute不符合要求',
            'max' => ':attribute超出限制',
            'JSON' => ':attribute格式错误',
        ], [
            'type_id' => '导航类型',
            'title' => '导航标题',
            'picture' => '图片信息',
            'link_type' => '链接类型',
            'link_target' => '链接目标',
            'sort' => '排序',
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
        // 保存
        $result = (new NavService())->update($request->input());

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '添加失败,已有相同类型的标题',
                'data' => null,
            ]);
        } else if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '修改失败',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '修改成功',
            'data' => null,
        ]);
    }

    /**
     * 删除导航
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
        ], [
            'required' => ':attribute不能为空',
            'integer' => ':attribute格式不正确',
            'min' => ':attribute错误',
        ], [
            'id' => 'id',
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
        // 执行删除
        $result = (new NavService())->delete($request->id);

        // 删除失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        } else if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '删除失败',
                'data' => null,
            ]);
        }

        // 成功
        return response()->json([
            'code' => 0,
            'msg' => '删除成功',
            'data' => null,
        ]);
    }
}
