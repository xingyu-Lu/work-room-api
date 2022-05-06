<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOfficeOutpatientNew;
use Illuminate\Http\Request;

class TechnicalOfficeOutpatientNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technical_office_outpatient_new = TechnicalOfficeOutpatientNew::first();

        return responder()->success($technical_office_outpatient_new);
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

        TechnicalOfficeOutpatientNew::create($params);

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
        $technical_office_outpatient_new = TechnicalOfficeOutpatientNew::find($id);

        return responder()->success($technical_office_outpatient_new);
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

        TechnicalOfficeOutpatientNew::updateOrCreate(['id' => $id], $params);

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
        $status = 1;

        TechnicalOfficeOutpatientNew::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
