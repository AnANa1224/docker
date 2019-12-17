<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ProductsService
{
    /**
     * 查询所有商品信息
     * @param $page
     * @return array|null
     */
    public function showPro($page)
    {
        // 查询商品
        /*$res = Product::where('status', '!=', '3')
            ->orderBy('sort', 'asc')
            ->offset(($page-1)*10)
            ->limit(10)
            ->get();*/
        /*$data = DB::table('pre_product')
            ->table('pre_category')
            ->where('status', '!=', '3')
            ->where('pre_product.category_id', '=', 'pre_category.id')
            ->get();*/
        $offset = $page == 1 ? 0 : ($page - 1) * 10 - 1;
        $limit = 10;
        $data = DB::select('select p.id,p.name,category_id,c.name as category_name,sale_num,content,p.sort,p.status,p.created_at,p.updated_at from pre_product as p,pre_category as c where p.category_id = c.id and p.status != ' . Product::STATUS_DEL . ' order by p.sort,p.id asc limit ' . ($offset . ',' . $limit));
        // dd($offset,$limit,$data);
        if (!$data) {
            return null;
        }

        // 处理分页信息
        $count = Product::where('status', '!=', Product::STATUS_DEL)->get()->count();
        $pageCount = ceil($count / 10);
        $page - 1 < 1 ? $prevPage = 1 : $prevPage = $page - 1;
        $page + 1 > $pageCount ? $nextPage = $pageCount : $nextPage = $page + 1;
        $jsonPage = '{"itemCount":' . $count . ',"currentPage":' . $page . ',"pageSize":10,"pageCount":' . $pageCount . ',"prevPage":' . $prevPage . ',"nextPage":' . $nextPage . '}';
        $page = json_decode($jsonPage);
        // $res = json_decode($res);
        // dd($res[0]);
        // dd($res);
        return ['data' => $data, 'page' => $page];
    }

    /**
     * 查询单条商品信息
     * @param int $id
     * @return bool|mixed
     */
    public function findPro(int $id)
    {
        // 查询商品
        $Product = Product::where('id', $id)->where('status', '!=', Product::STATUS_DEL)->first();
        if (!$Product) {
            return false;
        }
        $ProductSku = Sku::where('product_id', $id)->get();
        $imgs = Tag::where('product_id', $id)->where('tag_id', Tag::PICTURE_TAG)->first('value');
        $propaganda = Tag::where('product_id', $id)->where('tag_id', Tag::PROPAGANDA_TAG)->first('value');
        $lift = Tag::where('product_id', $id)->where('tag_id', Tag::LIFT_TAG)->first('value');
        if ($imgs['value'] !== null) {
            $imgs = explode(',', $imgs->value);
        }
        if ($ProductSku) {
            $data = json_decode($Product);
            $data->skus = json_decode($ProductSku);
            $data->imgs = $imgs;
            $data->propaganda = $propaganda ? $propaganda->value : '';
            $data->lift = $lift ? $lift->value : '';
            if (!$data) {
                return false;
            }
        }

        return $data;
    }

    /**
     * 添加商品
     * @param array $data
     * @return Product|null
     */
    public function addPro(array $data)
    {
        // 添加商品
        $Product = new Product();
        $Product->category_id = $data['category_id'];
        $Product->name = $data['name'];
        $Product->content = $data['content'];
        $Product->sort = $data['sort'];
        $Product->status = $data['status'];
        /*DB::beginTransaction();
        if (!$Product->save()) {
            DB::rollBack();
        }
        DB::commit();*/
        if (!$Product->save()) {
            return null;
        }
        return $Product;
    }

    /**
     * 修改商品
     * @param array $data
     * @return int|null
     */
    public function editPro(array $data)
    {
        $Product = Product::find($data['id']);
        if (!$Product) {
            return -1;
        }
        // 修改商品
        $Product->category_id = $data['category_id'];
        $Product->name = $data['name'];
        $Product->content = $data['content'];
        null;
        isset($data['sort']) ? $Product->sort = $data['sort'] : null;
        isset($data['status']) ? $Product->status = $data['status'] : null;

        if (!$Product->save()) {
            return null;
        }
        return $Product;
    }

    /**
     * 删除商品
     * @param int $id
     * @return bool|int
     */
    public function delPro(int $id)
    {
        $Product = Product::find($id);
        if (!$Product) {
            return -1;
        }

        // 真删
        /*DB::beginTransaction();
        $res = \App\Models\Product::destroy($id);
        $rows = \App\Models\Sku::where('product_id', $id)->delete();
        if (!$res || !$rows) {
            DB::rollBack();
            return false;
        }
        DB::commit();*/
        // 伪删
        $model = Sku::where('product_id', $id)->first();
        if (!$model) {
            $res = Product::where('id', $id)->update(['status' => Product::STATUS_DEL]);
            return true;
        }
        DB::beginTransaction();
        $res = Product::where('id', $id)->update(['status' => Product::STATUS_DEL]);
        $rows = Sku::where('product_id', $id)->update(['status' => Sku::STATUS_DEL]);
        if (!$res || !$rows) {
            DB::rollBack();
            return false;
        }
        DB::commit();

        return true;
    }

    /**
     * 添加商品sku
     * @param array $data
     * @return bool|string
     */
    public function addSku(array $data)
    {
        /*$Sku = new Sku();
        $Sku->product_id = $data['product_id'];
        $Sku->original_price = $data['original_price'];
        $Sku->price = $data['original_price'];
        $data['attr1'] ? $Sku->attr1 = $data['attr1'] : null ;
        $data['attr2'] ? $Sku->attr2 = $data['attr2'] : null ;
        $data['attr3'] ? $Sku->attr3 = $data['attr3'] : null ;
        $Sku->quantity = $data['quantity'];
        $Sku->sort = $data['sort'];
        $Sku->status = $data['status'];
        if (!$Sku->save()) {
            return null;
        }
        return $Sku;*/
        // 判断分类是否支持属性
        $Product = Product::find($data['product_id']);
        $cate_id = json_decode($Product)->category_id;
        $Category = Category::find($cate_id);
        $cate_attr = json_decode(json_decode($Category)->property);
        if ($cate_attr === null) {
            return '该商品的分类暂不支持添加属性';
        } elseif (array_key_exists('attr1', $data) && !property_exists($cate_attr, 'attr1')) {
            return '该商品的分类暂不支持添加属性attr1: ' . $data['attr1'];
        } elseif (array_key_exists('attr2', $data) && !property_exists($cate_attr, 'attr2')) {
            return '该商品的分类暂不支持添加属性attr2: ' . $data['attr2'];
        } elseif (array_key_exists('attr3', $data) && !property_exists($cate_attr, 'attr2')) {
            return '该商品的分类暂不支持添加属性attr3: ' . $data['attr3'];
        }
        $Sku = Sku::firstOrCreate(
            [
                'product_id' => $data['product_id'],
                'attr1' => $cate_attr->attr1 ? $data['attr1'] : null,
                'attr2' => $cate_attr->attr2 ? $data['attr2'] : null,
                'attr3' => $cate_attr->attr3 ? $data['attr3'] : null,
            ],
            $data
        );
        if (!$Sku) {
            return false;
        }
        /*// 属性完全重复
        if (!$Sku->wasRecentlyCreated){
            return -1;
        }*/
        return $Sku;
    }

    /**
     * 查询单条商品Sku
     * @param int $id
     * @return |null
     */
    public function findSku(int $id)
    {
        // 查询商品
        $ProductSku = Sku::find($id);
        if (!$ProductSku) {
            return null;
        }

        return $ProductSku;
    }

    /**
     * 修改商品sku
     * @param array $data
     * @return bool|int
     */
    public function editSku(array $data)
    {
        // 未能获取到
        $Product = Sku::find($data['id']);
        if (!$Product) {
            return -1;
        }
        $Sku = Sku::where('id', $data['id'])
            ->update($data);
        if (!$Sku) {
            return false;
        }
        return true;
    }

    /**
     * 删除商品Sku
     * @param int $id
     * @return bool|int
     */
    public function delSku(int $id)
    {
        $Sku = Sku::where('status', Sku::STATUS_DEL)->find($id);
        if ($Sku) {
            return -1;
        }

        // 真删
        // $rows = \App\Models\Sku::where('product_id', $id)->delete();

        // 伪删
        $rows = Sku::where('id', $id)->update(['status' => Sku::STATUS_DEL]);
        if (!$rows) {
            return false;
        }
        return true;
    }

    /**
     * 删除商品Sku
     * @param array $data
     * @return bool
     */
    public function delSkuAttr(array $data)
    {
        if (count($data) > 0) {
            DB::beginTransaction();
            foreach ($data as $value) {
                $value = json_decode($value);
                $res = Sku::where('product_id', $value->product_id)->where($value->attr, $value->value)->get();
                if ($res) {
                    $rows = Sku::where('product_id', $value->product_id)->where($value->attr, $value->value)->delete();
                    if (!$rows) {
                        DB::rollBack();
                        return false;
                    }
                }
            }
            DB::commit();
        } else {
            return true;
        }

        // 真删
        return true;
    }

    /**
     * 添加商品tag
     * @param array $data
     * @return bool|int
     */
    public function addTag(array $data)
    {
        DB::beginTransaction();
        foreach ($data as $val) {
            $val = json_decode($val, true);
            $Tag = Tag::firstOrCreate(
                [
                    'product_id' => $val['product_id'],
                    'tag_id' => $val['tag_id'],
                ],
                $val
            );
            if (!$Tag) {
                DB::rollBack();
                return false;
            }
            // 已存在标签
            if (!$Tag->wasRecentlyCreated) {
                DB::rollBack();
                return -1;
            }
        }
        DB::commit();
        return true;
    }

    /**
     * 修改商品Tag
     * @param array $data
     * @return bool
     */
    public function editTag(array $data)
    {
        $Tag = Tag::where('product_id', $data['product_id'])->where('tag_id', $data['tag_id'])
            ->update($data);
        if (!$Tag) {
            return false;
        }
        return true;
    }

    /**
     * 删除商品Tag
     * @param int $id
     * @return bool|int
     */
    public function delTag(int $id)
    {
        $Tag = Tag::where('status', Tag::STATUS_DEL)->find($id);
        if ($Tag) {
            return -1;
        }

        // 真删
        // $rows = \App\Models\Sku::where('product_id', $id)->delete();

        // 伪删
        $rows = Tag::where('id', $id)->update(['status' => Tag::STATUS_DEL]);
        if (!$rows) {
            return false;
        }
        return true;
    }

    /**
     * 查询单条商品Tag
     * @param int $id
     * @return |null
     */
    public function findTag(int $id)
    {
        // 查询
        $Tag = Tag::where('product_id', $id)->where('status', '!=', Tag::STATUS_DEL)->get();
        if (!$Tag) {
            return null;
        }

        return $Tag;
    }

}
