<?php
/**------- 订单存放在db3中--------*
 */

namespace App\Services;


use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderServer
{
    private function mysql($key)
    {
        Redis::select(3);
        while(1) {
            //如果队列中存在数据
            if (Redis::llen($key) > 0) {
                //读取数据
                $data = Redis::rpop($key);
                //数据转换
                $data = unserialize($data);
                //数据库操作
                $Order = new Order();
                $Order->user_id = $data['user_id'];
                $Order->product_id = $data['product_id'];
                $Order->order = $data['order'];
                $Order->status = $data['status'];
                if (!$Order->save()) {
                    return false;
                }
                return $Order;

            } else {
                //如果队列中没有数据的话 可以休息一下
                sleep(5);
                return false;
            }
        }
    }


    public function find(array $data)
    {
        // 选择数据库
        Redis::select(3);
        // 查询数据
        $res = Redis::lindex($data['product_id'], $data['id']-1);
        $res = unserialize($res);
        $res['id'] = Redis::llen($data['product_id']);
        return $res;
    }

    /**
     * @param array $data
     * @return bool|int|mixed
     */
    public function create(array $data)
    {

        // 库存减1
        $pro_quantity = Redis::hget($data['product_id'], 'quantity');
        if ($pro_quantity <= 0) {
//            $this->mysql($data['product_id']);
            return -1;
        }
        // 开启事务
        Redis::multi();
        // 选择数据库
        Redis::select(1);
        $row = Redis::hincrby($data['product_id'], 'quantity', -1);
        if (!$row){
            Redis::discard();
            return false;
        }
        // 选择数据库
        Redis::select(3);
        // 完善订单数据
        $res['product_id'] = $data['product_id'];
        $res['user_id'] = $data['user_id'];
        $res['status'] = $data['status'];
        $res['order'] = uniqid();
        // 添加订单
        $res = serialize($res);
        $row = Redis::lpush($data['product_id'], $res);
        if (!$row){
            Redis::discard();
            return false;
        }
        Redis::exec();
        Redis::expire(3, 3);
        $res = unserialize($res);
        $res['id'] = Redis::llen($data['product_id']);
        return $res;
    }

    public function add(array $data){
        // 缓存操作

        //数据库操作
        DB::beginTransaction();

        // 生成订单
        $Order = new Order();
        $Order->user_id = $data['user_id'];
        $Order->product_id = $data['product_id'];
        $Order->order = $data['order'];
        $Order->status = $data['status'];
        if (!$Order->save()) {
            DB::rollBack();
            return false;
        }

        // 减库存
        $res = Product::find($data['product_id']);
        Product::where('id', $data['product_id'])
            ->update(['quantity' => $res['quantity']-1]);

        DB::commit();

        return $Order;
    }

    public function cancel(array $data)
    {
        // 选择数据库
        Redis::select(3);

        // 开启事务
        Redis::multi();
        // 选择数据库
        Redis::select(1);
        // 库存加1
        $row = Redis::hincrby($data['id'], 'quantity', 1);
        if (!$row){
            Redis::discard();
            return false;
        }
        // 选择数据库
        Redis::select(3);
        // 删除订单
        $row = Redis::lRemove($data['product_id'], $data['id']-1, 1);
        dd($row);
        if (!$row){
            Redis::discard();
            return false;
        }
        Redis::exec();
        return true;
    }

    public function delete(int $id)
    {
        // 选择数据库
        Redis::select(3);
        return false;
    }
}
