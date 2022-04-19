<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeMember;
use Illuminate\Http\Request;

class TechnicalOfficeMembersController extends Controller
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

        if ($params['staff_name']) {
            $where[] = ['staff_name', 'like', '%' . $params['staff_name'] . '%'];
        }

        if ($params['office_name']) {
            $where[] = ['office_name', 'like', '%' . $params['office_name'] . '%'];
        }

        $office_members = TechnicalOfficeMember::where($where)->orderBy('id', 'desc')->paginate(30);

        return responder()->success($office_members);
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

        $member = TechnicalOfficeMember::where('staff_id', $params['staff_id'])->first();

        if ($member) {
            throw new BaseException(['msg' => '该成员已添加']);
        }

        $office = TechnicalOffice::find($params['office_id']);

        $staff = Staff::find($params['staff_id']);

        $insert_data = [
            'office_id' => $params['office_id'],
            'office_name' => $office['name'],
            'staff_id' => $params['staff_id'],
            'staff_name' => $staff['name'],
            'is_head' => $params['is_head'],
        ];

        TechnicalOfficeMember::create($insert_data);

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
        $member = TechnicalOfficeMember::find($id);

        return responder()->success($member);
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

        $staff = Staff::find($params['staff_id']);

        $update_data = [
            'office_id' => $params['office_id'],
            'office_name' => $office['name'],
            'staff_id' => $params['staff_id'],
            'staff_name' => $staff['name'],
            'is_head' => $params['is_head'],
        ];

        TechnicalOfficeMember::updateOrCreate(['id' => $params['id']], $update_data);

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
        TechnicalOfficeMember::where('id', $id)->delete();

        return responder()->success();
    }
}
