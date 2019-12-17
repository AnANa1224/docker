<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class ProductServer
{
    /**
     * 查询单条商品信息
     * @param int $id
     * @return bool|mixed
     */
    public function findPro(int $id)
    {
        $pro = Redis::hgetall($id);
        if ( $pro !== []) {
            return $pro;
        }
        // 查询商品
        $pro = Product::where('id', $id)->where('status', '!=', Product::STATUS_DEL)->first();
        $res = Redis::hmset($id, json_decode($pro,true));

        if (!$pro) {
            return false;
        }
        return $pro;
    }

    /**
     * @param array $data
     * @return Product|bool
     */
    public function createPro(array $data)
    {
        $Product = new Product();
        $Product->name = $data['name'];
        $Product->price = $data['price'];
        $Product->quantity = $data['quantity'];
        $Product->start_time = $data['start_time'];
        $Product->end_time = $data['end_time'];
        $Product->status = $data['status'];
        if (!$Product->save()) {
            return false;
        }
        return $Product;
    }
}
