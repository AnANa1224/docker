<?php

namespace App\Http\Controllers\ProductApi;


use App\Http\Controllers\Controller;
use App\Services\ProductsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * 查询所有商品信息
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
            'id' => '分类id',
        ]);
        $request->page ? $page = $request->page : $page = 1;
        // 查询
        $result = (new ProductsService())->showPro($page);
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
            'data' => $result['data'],
            'page' => $result['page']
        ]);
    }

    /**
     * 查询单条商品信息
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
        $result = (new ProductsService())->findPro($request->id);
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
     * 添加一条商品
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|integer',
                'name' => 'required|string|min:1|max:20',
                'content' => 'required|string|max:2000',
                'sort' => 'integer|min:0|max:10',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute为必填项',
                'string' => ':attribute类型为字符串',
                'integer' => ':attribute类型为整数',
                'min' => ':attribute不符合最小要求',
                'max' => ':attribute超出最大限制',
                'regex' => ':attribute格式错误',
            ], [
                'category_id' => '分类id',
                'name' => '商品名称',
                'content' => '商品描述',
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
        $result = (new ProductsService())->addPro($request->input());

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
     * 修改商品信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|integer',
                'name' => 'required|string|min:1|max:20',
                'content' => 'required|string|max:2000',
                'sort' => 'integer|min:0|max:10',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute为必填项',
                'string' => ':attribute类型为字符串',
                'integer' => ':attribute类型为整数',
                'min' => ':attribute不符合最小要求',
                'max' => ':attribute超出最大限制',
                'regex' => ':attribute格式错误',
            ], [
                'category_id' => '分类id',
                'name' => '商品名称',
                'content' => '商品描述',
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
        $result = (new ProductsService())->editPro($request->input());

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        } elseif ($result === -2) {
            return response()->json([
                'code' => -1,
                'msg' => '已存在该属性',
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
            'data' => $result->toArray(),
        ]);
    }

    /**
     * 删除商品信息
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
            'integer' => ':attribute为整数'
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
        // 执行删除
        $result = (new ProductsService())->delPro($request->id);

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

    /**
     * 添加商品属性单价库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSku(Request $request)
    {
        $datas = $request->all();
        DB::beginTransaction();
        for ($i = 0; $i < count($datas); $i++) {
            $data = json_decode($datas[$i],true);
            // 保存
            $result = (new ProductsService())->addSku($data);
            if (!$result) {
                DB::rollBack();
                return response()->json([
                    'code' => -1,
                    'msg' => '添加失败',
                    'data' => null,
                ]);
            }
        }
        DB::commit();
        // 数据效验
        /*$validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'original_price' => [
                    'required',
                    'regex:/^[1-9]+\d{1,8}(.\d{1,2})?$|^\d+.\d{1,2}$/',
                    'min:0',
                    'max:1000000'
                ],
                'price' => [
                    'required',
                    'regex:/^[1-9]+\d{1,8}(.\d{1,2})?$|^\d+.\d{1,2}$/',
                    'min:0',
                    'max:1000000'
                ],
                'attr1' => 'string|max:20',
                'attr2' => 'string|max:20',
                'attr3' => 'string|max:20',
                'quantity' => 'required|integer|min:0',
                'sort' => 'integer|min:0|max:10',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute为必填项',
                'integer'  => ':attribute类型为整数',
                'min'      => ':attribute不符合最小要求',
                'max'      => ':attribute超出最大限制',
                'JSON'     => ':attribute格式错误',
                'regex'     => ':attribute格式错误',
            ], [
                'product_id' => '商品id',
                'original_price' => '商品原价',
                'price' => '商品售价',
                'attr1' => '属性1',
                'attr2' => '属性2',
                'attr3' => '属性3',
                'quantity' => '商品库存',
                'sort' => '排序',
                'status' => '状态',
            ]);
        if ($validator->fails()) {
            // dd($validator->errors()->first());
            // return $validator->errors()->first();
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }
        // 保存
        $result = (new ProductsService())->addSku($request->input());*/

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '属性相同,添加失败',
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
     * 删除商品属性单价库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSku(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'required' => ':attribute不能为空',
            'integer' => ':attribute为整数'
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
        // 执行删除
        $result = (new ProductsService())->delSku($request->id);

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

    /**
     * 删除商品属性
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSkuAttr(Request $request)
    {
        // 执行删除
        $result = (new ProductsService())->delSkuAttr($request->all());

        // 删除失败
        if (!$result) {
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

    /**
     * 获取商品属性单价库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findSku(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'required' => ':attribute不能为空',
            'numeric' => ':attribute格式不正确'
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
        $result = (new ProductsService())->findSku($request->id);
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
     * 修改商品属性单价库存
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSku(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'original_price' => [
                    'required',
                    'regex:/^[1-9]+\d{1,8}(.\d{1,2})?$|^\d+.\d{1,2}$/',
                    'min:0',
                    'max:1000000'
                ],
                'price' => [
                    'required',
                    'regex:/^[1-9]+\d{1,8}(.\d{1,2})?$|^\d+.\d{1,2}$/',
                    'min:0',
                    'max:1000000'
                ],
                'attr1' => 'string|max:20',
                'attr2' => 'string|max:20',
                'attr3' => 'string|max:20',
                'quantity' => 'required|integer|min:0',
                'sort' => 'integer|min:0|max:10',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute为必填项',
                'integer' => ':attribute类型为整数',
                'min' => ':attribute不符合最小要求',
                'max' => ':attribute超出最大限制',
                'JSON' => ':attribute格式错误',
                'regex' => ':attribute格式错误',
            ], [
                'product_id' => '商品id',
                'original_price' => '商品原价',
                'price' => '商品售价',
                'attr1' => '属性1',
                'attr2' => '属性2',
                'attr3' => '属性3',
                'quantity' => '商品库存',
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
        $result = (new ProductsService())->editSku($request->input());

        // 保存失败
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '数据不存在',
                'data' => null,
            ]);
        } elseif ($result === -2) {
            return response()->json([
                'code' => -1,
                'msg' => '属性重复,修改失败',
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
            'data' => null,
        ]);
    }


    /**
     * 添加商品标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTag(Request $request)
    {
        // 数据效验
        /*$validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'tag_id' => 'required|integer|min:1|max:3',
                'value' => 'required|string|max:30000',
                'status' => 'required|integer|min:1|max:3',
            ], [
                'required' => ':attribute不能为空',
                'integer'  => ':attribute类型为整数',
                'string'  => ':attribute类型为字符串',
                'min'      => ':attribute不符合要求',
                'max'      => ':attribute超出限制',
            ], [
                'product_id' => '商品id',
                'tag_id' => '标签id',
                'value' => '标签值',
                'status' => '状态',
            ]);
        if ($validator->fails()) {
            // dd($validator->errors()->first());
            // return $validator->errors()->first();
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first(),
                'data' => [],
            ]);
        }*/
        // 保存
        $result = (new ProductsService())->addTag($request->all());

        // 保存失败
        if (!$result) {
            return response()->json([
                'code' => -1,
                'msg' => '添加失败',
                'data' => null,
            ]);
        }
        if ($result === -1) {
            return response()->json([
                'code' => -1,
                'msg' => '此类标签已存在,添加失败',
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
     * 删除商品标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTag(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|integer',
            ], [
                'required' => ':attribute不能为空',
                'integer' => ':attribute为整数'
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
        // 执行删除
        $result = (new ProductsService())->delTag($request->id);

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

    /**
     * 获取商品标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findTag(Request $request)
    {
        // 验证数据
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
            ], [
                'required' => ':attribute不能为空',
                'integer' => ':attribute格式为整数'
            ], [
                'product_id' => '商品id',
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
        $result = (new ProductsService())->findTag($request->product_id);
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
     * 修改商品标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTag(Request $request)
    {
        // 数据效验
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|integer',
                'tag_id' => 'required|integer',
                'value' => 'string|nullable|max:30000',
            ], [
                'required' => ':attribute为必填项',
                'integer' => ':attribute类型为整数',
                'string' => ':attribute类型为字符串',
                'min' => ':attribute不符合要求',
                'max' => ':attribute超出限制',
            ], [
                'product_id' => '商品id',
                'tag_id' => '标签id',
                'value' => '标签值',
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
        $result = (new ProductsService())->editTag($request->input());

        // 保存失败
        if (!$result) {
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
}
