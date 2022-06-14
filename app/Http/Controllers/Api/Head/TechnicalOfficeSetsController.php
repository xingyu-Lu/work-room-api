<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOffice;
use Illuminate\Http\Request;

class TechnicalOfficeSetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $office = TechnicalOffice::find($params['id']);

        $data_arr = [];

        if ($office['type'] == 0) {
            $data_arr = [
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门介绍',
                    'type' => $office['type'],
                    'url' => '/kssz-ksjs-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门医生',
                    'type' => $office['type'],
                    'url' => '/kssz-ksys-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门动态',
                    'type' => $office['type'],
                    'url' => '/kssz-ksdt-index?id=',
                ],
                // [
                //     'office_id' => $office['id'],
                //     'office_name' => $office['name'],
                //     'name' => '部门门诊',
                //     'type' => $office['type'],
                //     'url' => '/kssz-outpatient-index?id=',
                // ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门成员',
                    'type' => $office['type'],
                    'url' => '/kssz-member-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '栏目设置',
                    'type' => $office['type'],
                    'url' => '/kssz-columnset-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门栏目',
                    'type' => $office['type'],
                    'url' => '/kssz-column-index?id=',
                ],
            ];
        } elseif ($office['type'] == 1) {
            $data_arr = [
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门介绍',
                    'type' => $office['type'],
                    'url' => '/kssz-ksjs-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '医生简介',
                    'type' => $office['type'],
                    'url' => '/kssz-ksys-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门动态',
                    'type' => $office['type'],
                    'url' => '/kssz-ksdt-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门成员',
                    'type' => $office['type'],
                    'url' => '/kssz-member-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '栏目设置',
                    'type' => $office['type'],
                    'url' => '/kssz-columnset-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门栏目',
                    'type' => $office['type'],
                    'url' => '/kssz-column-index?id=',
                ],
            ];
        } elseif ($office['type'] == 2) {
            $data_arr = [
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '介绍',
                    'type' => $office['type'],
                    'url' => '/kssz-ksjs-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '动态',
                    'type' => $office['type'],
                    'url' => '/kssz-ksdt-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门成员',
                    'type' => $office['type'],
                    'url' => '/kssz-member-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '栏目设置',
                    'type' => $office['type'],
                    'url' => '/kssz-columnset-index?id=',
                ],
                [
                    'office_id' => $office['id'],
                    'office_name' => $office['name'],
                    'name' => '部门栏目',
                    'type' => $office['type'],
                    'url' => '/kssz-column-index?id=',
                ],
            ];
        }

        $data_arr = array_chunk($data_arr, 6);

        return responder()->success($data_arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
