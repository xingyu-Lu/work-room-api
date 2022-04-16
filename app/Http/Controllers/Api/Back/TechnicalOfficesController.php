<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\TechnicalOffice;
use Illuminate\Http\Request;

class TechnicalOfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $where = [];

        if (isset($params['office_name']) && $params['office_name']) {
            $where[] = ['name', 'like', '%' . $params['office_name'] . '%'];
        }

        $offices = TechnicalOffice::where($where)->orderBy('id', 'desc')->paginate(100);

        return responder()->success($offices);
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

        $office = TechnicalOffice::where('name', $params['name'])->first();

        if ($office) {
            throw new BaseException(['msg' => '科室已添加']);
        }

        TechnicalOffice::create($params);

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
        $office = TechnicalOffice::find($id);

        return responder()->success($office);
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

        $params['status'] = 0;

        TechnicalOffice::updateOrCreate(['id' => $id], $params);

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
        //
    }

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        TechnicalOffice::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
