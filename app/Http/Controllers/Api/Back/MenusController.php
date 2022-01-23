<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
