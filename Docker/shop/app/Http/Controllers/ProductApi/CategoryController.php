<?php

namespace App\Http\Controllers\ProductApi;


use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * 查询所有分类信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
        ], [
            'integer' => ':attribute格式不正确'
        ], [
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
        // 查询
        $result = (new CategoryService())->show($page);
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
            'data' => $result['res'],
            'page' => $result['page']
        ]);
    }

    /**
     * 查询单条分类信息
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
            'id' => '分类id',
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
        $result = (new CategoryService())->find($request->id);
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
     * 添加一条分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:20',
            'attr1' => 'string|nullable|max:5',
            'attr2' => 'string|nullable|max:5',
            'attr3' => 'string|nullable|max:5',
            'sort' => 'integer|min:0|max:10',
            'status' => 'required|integer|min:1|max:3',
        ], [
            'required' => ':attribute为必填项',
            'string' => ':attribute类型错误',
            'integer' => ':attribute类型错误',
            'min' => ':attribute长度不符合要求',
            'max' => ':attribute超过限制',
            'JSON' => ':attribute格式错误',
        ], [
            'name' => '分类名称',
            'attr1' => '分类属性',
            'attr2' => '分类属性',
            'attr3' => '分类属性',
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
        $result = (new CategoryService())->add($request->input());

        // 保存失败
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
            'data' => $result->toArray(),
        ]);
    }

    /**
     * 修改分类信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
            'attr1' => 'string|nullable|max:5',
            'attr2' => 'string|nullable|max:5',
            'attr3' => 'string|nullable|max:5',
            'name' => 'required|string|min:2|max:20',
            'sort' => 'integer|min:0|max:10',
            'status' => 'required|integer|min:1|max:3',
        ], [
            'required' => ':attribute为必填项',
            'integer' => ':attribute类型错误',
            'min' => ':attribute长度不符合要求',
            'max' => ':attribute超过限制',
            'JSON' => ':attribute格式错误',
        ], [
            'id' => '分类id',
            'attr1' => '分类属性',
            'attr2' => '分类属性',
            'attr3' => '分类属性',
            'name' => '分类名称',
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
        $result = (new CategoryService())->edit($request->input());

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        } elseif (!$result) {
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
            'data' => $result,
        ]);
    }

    /**
     * 删除一条分类记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'required' => ':attribute不能为空',
            'integer' => ':attribute格式不正确'
        ], [
            'id' => '分类id',
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
        $result = (new CategoryService())->del($request->id);

        // 删除失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        } elseif (!$result) {
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

