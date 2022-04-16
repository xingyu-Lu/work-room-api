<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $mobile = $params['mobile'] ?? '';
        $password = md5($params['password'] ?? '');

        $staff = Staff::where('mobile', $mobile)->first();

        if ($staff && $staff['status'] == 1) {
            if ($password != $staff['password']) {
                throw new BaseException(['msg' => '密码错误']);
            }

            $token = Auth::guard('h-api')->login($staff);

            return responder()->success(['token' => $token])->respond();
        } elseif ($staff && $staff['status'] == 0) {
            throw new BaseException(['msg' => '账号待审核']);
        } else {
            throw new BaseException(['msg' => '账号不存在']);
        }
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
