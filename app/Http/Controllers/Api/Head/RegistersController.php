<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Mail\SendCode;
use App\Models\Code;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistersController extends Controller
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

        $code = Code::where('code', $params['code'])->where('status', 1)->orderBy('id', 'desc')->first();

        if (empty($code)) {
            throw new BaseException(['msg' => '验证码错误']);
        }

        if (time() > $code['release_time']+60*60*2) {
            throw new BaseException(['msg' => '验证码超时']);   
        }

        $code->status = 0;

        $code->save();

        $insert_data = [
            'name' => $params['name'],
            'mobile' => $params['mobile'],
            'email' => $params['email'],
            'password' => md5($params['password']),
        ];

        Staff::create($insert_data);

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

    public function code(Request $request)
    {
        $params = $request->all();

        $email = $params['email'];

        $code = rand(1000, 9999);

        $insert_data = [
            'code' => $code,
            'release_time' => time(),
        ];

        Code::create($insert_data);

        Mail::to($email)->send(new SendCode($code));

        return responder()->success();
    }
}
