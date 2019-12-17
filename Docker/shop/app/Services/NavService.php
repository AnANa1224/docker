<?php

namespace App\Services;

use App\Models\Nav;
use Illuminate\Support\Facades\Storage;

class NavService
{
    /**
     * 查询某一类型所有导航信息
     * @param $type_id
     * @param $page
     * @return array|null
     */
    public function show($type_id, $page)
    {
        // 查询分类
        $data = Nav::where('type_id', $type_id)
            ->where('status', '!=', Nav::STATUS_DEL)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->offset($page == 1 ? 0 : ($page - 1) * 10 - 1)
            ->limit(10)
            ->get();
        if (!$data) {
            return null;
        }
        // 处理分页信息
        $count = Nav::where('type_id', $type_id)->get()->count();
        $pageCount = ceil($count / 10);
        $page - 1 < 1 ? $prevPage = 1 : $prevPage = $page - 1;
        $page + 1 > $pageCount ? $nextPage = $pageCount : $nextPage = $page + 1;
        $jsonPage = '{"itemCount":' . $count . ',"currentPage":' . $page . ',"pageSize":10,"pageCount":' . $pageCount . ',"prevPage":' . $prevPage . ',"nextPage":' . $nextPage . '}';
        $page = json_decode($jsonPage);

        return ['data' => $data, 'page' => $page];
    }

    /**
     * 查询单条导航信息
     * @param $id
     * @return bool
     */
    public function find($id)
    {
        $data = Nav::where('id', $id)->first();
        if (!$data) {
            return false;
        }
        return $data;
    }

    /**
     * 新增导航信息
     * @param array $data
     * @return bool|int
     */
    public function create(array $data)
    {
        $res = Nav::firstOrCreate(
            [
                'type_id' => $data['type_id'],
                'title' => $data['title']
            ],
            $data
        );
        if (!$res) {
            return false;
        }
        // 属性完全重复
        if (!$res->wasRecentlyCreated) {
            return -1;
        }
        return $res;
    }

    /**
     * 修改导航信息
     * @param array $data
     * @return bool|int
     */
    public function update(array $data)
    {
        $res = Nav::where('type_id', $data['type_id'])->where('title', $data['title'])->first();
        if ($res && $res->id != $data['id']) {
            return -1;
        }

        $rows = Nav::where('id', $data['id'])->update($data);
        if (!$rows) {
            return false;
        }

        return true;
    }

    /**
     * 删除导航信息
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {
        $res = Nav::where('status', Nav::STATUS_DEL)->find($id);
        $ress = Nav::find($id);

        if ($res || !$ress) {
            return -1;
        }

        $rows = Nav::where('id', $id)->update(['status' => Nav::STATUS_DEL]);
        if (!$rows) {
            return false;
        }
        return true;

    }
}
