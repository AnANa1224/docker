<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    /**
     * 查询所有分类信息
     * @param $page
     * @return array|null
     */
    public function show($page)
    {
        // 查询分类
        $res = Category::where('status', '!=', Category::STATUS_DEL)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->offset($page == 1 ? 0 : ($page - 1) * 10 - 1)
            ->limit(10)
            ->get();
        if (!$res) {
            return null;
        }
        // 处理分页信息
        $count = Category::where('status', '!=', '3')->get()->count();
        $pageCount = ceil($count / 10);
        $page - 1 < 1 ? $prevPage = 1 : $prevPage = $page - 1;
        $page + 1 > $pageCount ? $nextPage = $pageCount : $nextPage = $page + 1;
        $jsonPage = '{"itemCount":' . $count . ',"currentPage":' . $page . ',"pageSize":10,"pageCount":' . $pageCount . ',"prevPage":' . $prevPage . ',"nextPage":' . $nextPage . '}';
        $page = json_decode($jsonPage);
        // 处理分类信息
        $res = json_decode($res);
        for ($i = 0; $i < count($res); $i++) {
            $data = $res[$i];
            $data->property = json_decode($data->property);
        }
        // dd($res);
        return ['res' => $res, 'page' => $page];
    }

    /**
     * 查询单条分类信息
     * @param int $id
     * @return mixed|null
     */
    public function find(int $id)
    {
        // 查询分类
        $res = Category::find($id);
        if (!$res) {
            return null;
        }
        $res = json_decode($res);
        $res->property = json_decode($res->property);
        return $res;
    }

    /**
     * 添加分类
     * @param array $data
     * @return Category|null
     */
    public function add(array $data)
    {
        // 添加分类
        if (array_key_exists('attr1', $data)) {
            $attr['attr1'] = $data['attr1'];
            if (array_key_exists('attr2', $data)) {
                $attr['attr2'] = $data['attr2'];
                if (array_key_exists('attr3', $data)) {
                    $attr['attr3'] = $data['attr3'];
                }
            }
            $attr = json_encode($attr);
        }
        $Category = new Category();
        $Category->name = $data['name'];
        isset($attr) ? $Category->property = $attr : null;
        $Category->sort = $data['sort'];
        $Category->status = $data['status'];

        if (!$Category->save()) {
            return null;
        }
        return $Category;
    }

    /**
     * 修改分类
     * @param array $data
     * @return array|int|mixed|null
     */
    public function edit(array $data)
    {
        $Category = Category::find($data['id']);
        if (!$Category) {
            return -1;
        }

        // 获取属性
        if (array_key_exists('attr1', $data)) {
            $attr['attr1'] = $data['attr1'];
            if (array_key_exists('attr2', $data)) {
                $attr['attr2'] = $data['attr2'];
                if (array_key_exists('attr3', $data)) {
                    $attr['attr3'] = $data['attr3'];
                }
            }
            $attr = json_encode($attr);
        }
        // 修改分类
        $Category->name = $data['name'];
        isset($attr) ? $Category->property = $attr : null;
        $Category->sort = $data['sort'];
        $Category->status = $data['status'];
        if (!$Category->save()) {
            return null;
        }
        $data = json_decode($Category);
        $data->property = json_decode($data->property);
        return $data;
    }

    /**
     * 删除分类
     * @param int $id
     * @return bool|int
     */
    public function del(int $id)
    {
        $Category = Category::find($id);
        if (!$Category) {
            return -1;
        }
        // 删除分类
        // 真删
        // $res = $Category->delete($id);
        /*if (!$res) {
            return false;
        }*/

        // 伪删
        DB::beginTransaction();
        $res = Category::where('id', $id)->update(['status' => Category::STATUS_DEL]);
        $ending = Product::where('category_id', $id)->update(['status' => Category::STATUS_DEL]);
        if (!$res) {
            DB::rollBack();
            return false;
        }
        /*$pids = Product::where('category_id', $id)->get('id');
        $pids = json_decode($pids);
        foreach ($pids as $val){
            $sku = json_decode(Sku::where('product_id', $val->id)->get());
            if ($sku){
                $rows = Sku::where('product_id', $val->id)->update(['status' => Category::STATUS_DEL]);
                if (!$rows){
                    dd($sku,$val->id,$rows);
                    DB::rollBack();
                    return false;
                }
            }
        }*/
        DB::commit();

        return true;
    }
}
