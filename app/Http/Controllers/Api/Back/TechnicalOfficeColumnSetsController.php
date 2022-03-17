<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeColumnSet;
use Illuminate\Http\Request;

class TechnicalOfficeColumnSetsController extends Controller
{
    public function list()
    {
        $office_column_sets = TechnicalOfficeColumnSet::get();

        return responder()->success($office_column_sets);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $where = [];

        if ($params['name']) {
            $where[] = ['name', 'like', '%' . $params['name'] . '%'];
        }

        if ($params['office_name']) {
            $where[] = ['office_name', 'like', '%' . $params['office_name'] . '%'];
        }

        $office_column_sets = TechnicalOfficeColumnSet::where($where)->paginate(10);

        return responder()->success($office_column_sets);
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

        $office = TechnicalOffice::find($params['office_id']);

        $insert_data = [
            'office_id' => $params['office_id'],
            'office_name' => $office['name'],
            'name' => $params['name'],
        ];

        TechnicalOfficeColumnSet::create($insert_data);

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
        $office_column_set = TechnicalOfficeColumnSet::find($id);

        return responder()->success($office_column_set);
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

        $office = TechnicalOffice::find($params['office_id']);

        $update_data = [
            'office_id' => $params['office_id'],
            'office_name' => $office['name'],
            'name' => $params['name'],
        ];

        TechnicalOfficeColumnSet::updateOrCreate(['id' => $params['id']], $update_data);

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
        TechnicalOfficeColumnSet::where('id', $id)->delete();

        return responder()->success();
    }
}
