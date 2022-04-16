<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
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

        if ($user) {
            $user = Staff::with('office')->where('id', $user['id'])->first();
            $this->staff = $user;
        }

        return true;
    }

    public function column_list()
    {
        $office_column_sets = TechnicalOfficeColumnSet::where('office_id', $this->staff->office['office_id'])->whereIn('status', [0, 1])->get();

        foreach ($office_column_sets as $key => $value) {
            if ($value['type'] == 0) {
                $value['type_name'] = '(图文或视频)';
            } else {
                $value['type_name'] = '(仅图)';
            }
        }

        return responder()->success($office_column_sets);
    }

    public function list(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $office_column_sets = TechnicalOfficeColumnSet::where('office_id', $params['office_id'])->whereIn('status', $where_arr)->get()->toArray();

        $office = TechnicalOffice::where('id', $params['office_id'])->first();

        foreach ($office_column_sets as $key => &$value) {
            $value['url'] = '/ksjs-column';
        }

        unset($value);

        if ($office['name'] == '门诊部') {
            $insert_arr = [
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '门诊坐诊医生简介',
                    'type' => 0,
                    'url' => '/ksjs-ksys',
                ],
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室动态',
                    'type' => 0,
                    'url' => '/ksjs-ksdt',
                ],
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室介绍',
                    'type' => 0,
                    'url' => '/ksjs_detail',
                ],
            ];
        } else {
            $insert_arr = [
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室门诊',
                    'type' => 0,
                    'url' => '/ksmz',
                ],
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室医生',
                    'type' => 0,
                    'url' => '/ksjs-ksys',
                ],
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室动态',
                    'type' => 0,
                    'url' => '/ksjs-ksdt',
                ],
                [
                    'id' => 0,
                    'office_id' => $params['office_id'],
                    'office_name' => $office['name'],
                    'name' => '科室介绍',
                    'type' => 0,
                    'url' => '/ksjs_detail',
                ],
            ];
        }

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
        if (empty($this->staff)) {
            throw new BaseException(['msg' => '未登录']);
        }

        if (empty($this->staff['office'])) {
            throw new BaseException(['msg' => '非科室成员']);
        }

        $params = $request->all();

        $where = [];

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
        if (empty($this->staff)) {
            throw new BaseException(['msg' => '未登录']);
        }

        if (empty($this->staff['office'])) {
            throw new BaseException(['msg' => '非科室成员']);
        }

        $params = $request->all();

        $insert_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'type' => $params['type'],
            'status' => 0,
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
        if (empty($this->staff)) {
            throw new BaseException(['msg' => '未登录']);
        }

        if (empty($this->staff['office'])) {
            throw new BaseException(['msg' => '非科室成员']);
        }

        $params = $request->all();

        $update_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'type' => $params['type'],
            'status' => 0
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
        if (empty($this->staff)) {
            throw new BaseException(['msg' => '未登录']);
        }

        if (empty($this->staff['office'])) {
            throw new BaseException(['msg' => '非科室成员']);
        }

        TechnicalOfficeColumnSet::where('id', $id)->where('office_id', $this->staff->office['office_id'])->delete();

        return responder()->success();
    }
}
