<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::where('is_enabled', Menu::IS_ENABLED_1)->get();

        return responder()->success($menus);
    }

    public function getTree($menus, $pid = 0, $list = [])
    {
        $list = [];

        foreach ($menus as $key => $value) {
            if ($value['pid'] != $pid) {
                continue;
            }

            if ($value['pid'] != 0) {
                $p_menu = Menu::find($value['pid']);
                $p_name = $p_menu->name;
            } else {
                $p_name = '无';
            }

            $list[$key]['id'] = $value['id'];
            $list[$key]['pid'] = $value['pid'];
            $list[$key]['name'] = $value['name'];
            $list[$key]['p_name'] = $p_name;
            $list[$key]['url'] = $value['url'];
            $list[$key]['icon'] = $value['icon'];
            $list[$key]['created_at'] = $value['created_at'];

            unset($menus[$key]);

            $list[$key]['sub'] = $this->getTree($menus, $value['id'], $list);
        }

        return array_values($list);
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        Menu::create($params);

        return responder()->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);

        if (empty($menu)) {
            throw new BaseException(['msg' => '菜单不存在']);
        }

        return responder()->success($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        Menu::updateOrCreate(['id' => $id], $params);

        return responder()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (empty($menu)) {
            throw new BaseException(['msg' => '菜单不存在']);
        }

        $menu_id = $this->getChildMenu($id);

        array_push($menu_id, (int)$id);

        //删除关联
        DB::table('role_has_menus')->whereIn('menu_id', $menu_id)->delete();

        Menu::whereIn('id', $menu_id)->delete();

        return responder()->success();
    }

    public function getChildMenu($pid, $menus = [])
    {
        static $list = [];

        if (empty($menus)) {
            $menus = Menu::get();
        }

        foreach ($menus as $key => $value) {
            if ($value['pid'] == $pid) {
                $list[] = $value['id'];
                unset($menus[$key]);
                $this->getChildmenu($value['id'], $menus);
            }
        }

        return $list;
    }
}
