<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeMember;
use Illuminate\Http\Request;

class TechnicalOfficeMembersController extends Controller
{
    public $staff = null;

    public function __construct()
    {
        $user = auth('h-api')->user();

        if ($user) {
            $user = Staff::with('office')->where('id', $user['id'])->first();
            $this->staff = $user;
        } else {
            throw new BaseException(['msg' => '未登录']);
        }

        if (empty($user['office'])) {
            throw new BaseException(['msg' => '非科室成员']);
        }

        if ($user['office']['is_head'] != 1) {
            throw new BaseException(['msg' => '非科室负责人']);   
        }

        return true;
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

        if ($params['staff_name']) {
            $where[] = ['staff_name', 'like', '%' . $params['staff_name'] . '%'];
        }

        $where[] = [
            'office_id', '=', $this->staff->office['office_id']
        ];

        $office_members = TechnicalOfficeMember::where($where)->paginate(10);

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

        $staff = Staff::find($params['staff_id']);

        $insert_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
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

        $staff = Staff::find($params['staff_id']);

        $update_data = [
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
        TechnicalOfficeMember::where('id', $id)->where('office_id', $this->staff->office['office_id'])->delete();

        return responder()->success();
    }
}
