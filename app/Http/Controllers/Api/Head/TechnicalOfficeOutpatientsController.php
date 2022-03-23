<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOfficeOutpatient;
use Illuminate\Http\Request;

class TechnicalOfficeOutpatientsController extends Controller
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

        $where[] = [
            'office_id', '=', $this->staff->office['office_id']
        ];

        $outpatient = TechnicalOfficeOutpatient::where($where)->paginate(50);

        return responder()->success($outpatient);
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

        $params['office_id'] = $this->staff->office['office_id'];

        $params['office_name'] = $this->staff->office['office_name'];

        TechnicalOfficeOutpatient::create($params);

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
        $outpatient = TechnicalOfficeOutpatient::find($id);

        return responder()->success($outpatient);
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

        $params['office_id'] = $this->staff->office['office_id'];

        $params['office_name'] = $this->staff->office['office_name'];

        $params['status'] = 0;

        TechnicalOfficeOutpatient::updateOrCreate(['id' => $id], $params);

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
}
