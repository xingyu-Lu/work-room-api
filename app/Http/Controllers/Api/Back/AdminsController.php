<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function info()
    {
        $user = auth('api')->user();

        return responder()->success($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_size = 1;

        $admins = Admin::orderBy('id', 'desc')->paginate($page_size);;

        return responder()->success($admins);
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

        $params['password'] = md5($params['password']);

        $admin = Admin::where('name', $params['name'])->first();

        if ($admin) {
            throw new BaseException(['msg' => '账号名已存在']);
        }

        Admin::create($params);

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
        $admin = Admin::where('id', $id)->first();

        return responder()->success($admin);
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
        $params = $request->all();

        $params['password'] = md5($params['password']);

        Admin::updateOrCreate(['id' => $id], $params);

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

    }

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        Admin::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
