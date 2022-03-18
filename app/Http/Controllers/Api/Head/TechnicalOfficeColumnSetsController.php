<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeColumnSet;
use Illuminate\Http\Request;

class TechnicalOfficeColumnSetsController extends Controller
{
    public $staff = null;

    public function __construct()
    {
        $user = auth('h-api')->user();

        $user = Staff::with('office')->where('id', $user['id'])->first();

        $this->staff = $user;

        return true;
    }

    public function list(Request $request)
    {
        $params = $request->all();

        $office_column_sets = TechnicalOfficeColumnSet::where('office_id', $params['office_id'])->get()->toArray();

        foreach ($office_column_sets as $key => &$value) {
            $value['url'] = '/ksjs_column';
        }

        unset($value);

        $insert_arr = [
            [
                'id' => 0,
                'office_id' => $this->staff->office['office_id'],
                'office_name' => $this->staff->office['office_name'],
                'name' => '科室门诊',
                'type' => 0,
                'url' => '/ksmz',
            ],
            [
                'id' => 0,
                'office_id' => $this->staff->office['office_id'],
                'office_name' => $this->staff->office['office_name'],
                'name' => '科室医生',
                'type' => 0,
                'url' => '/ksjs-ksys',
            ],
            [
                'id' => 0,
                'office_id' => $this->staff->office['office_id'],
                'office_name' => $this->staff->office['office_name'],
                'name' => '科室动态',
                'type' => 0,
                'url' => '/ksjs-ksdt',
            ],
            [
                'id' => 0,
                'office_id' => $this->staff->office['office_id'],
                'office_name' => $this->staff->office['office_name'],
                'name' => '科室介绍',
                'type' => 0,
                'url' => '/ksjs_detail',
            ],
        ];

        foreach ($insert_arr as $key => $value) {
            array_unshift($office_column_sets, $value);   
        }

        $office_column_sets = array_chunk($office_column_sets, 7);

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

        $where[] = ['office_id', '=', $this->staff->office['office_id']];

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

        $insert_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'type' => $params['type'],
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
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'type' => $params['type'],
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
