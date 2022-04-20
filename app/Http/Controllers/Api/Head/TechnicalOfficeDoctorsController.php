<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOfficeDoctor;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficeDoctorsController extends Controller
{
    public $staff = null;

    public function __construct()
    {
        $user = auth('h-api')->user();

        if ($user) {
            $user = Staff::with('office')->where('id', $user['id'])->first();
            $this->staff = $user;
        } else {
            throw new BaseException(['msg' => '未登录', 'status' => 401]);
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

        if ($params['name']) {
            $where[] = ['name', 'like', '%' . $params['name'] . '%'];
        }

        $where[] = ['office_id', '=', $this->staff->office['office_id']];

        $office_doctors = TechnicalOfficeDoctor::where($where)->paginate(10);

        foreach ($office_doctors as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['url'] = $url;
        }

        return responder()->success($office_doctors);
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
            'file_id' => $params['img'] ?? 0,
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'professional' => $params['professional'] ?? '',
            'excel' => $params['excel'] ?? '',
            'content' => $params['content'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'status' => 0,
        ];

        TechnicalOfficeDoctor::create($insert_data);

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
        $office_doctor = TechnicalOfficeDoctor::find($id);

        $file = UploadFile::find($office_doctor['file_id']);
        $url = '';
        if ($file) {
            $url = Storage::disk('public')->url($file['file_url']);
        }
        $office_doctor->url = $url;

        return responder()->success($office_doctor);
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

        $update_data = [
            'file_id' => $params['img'] ?? 0,
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'name' => $params['name'],
            'professional' => $params['professional'] ?? '',
            'excel' => $params['excel'] ?? '',
            'content' => $params['content'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'status' => 0,
        ];

        TechnicalOfficeDoctor::updateOrCreate(['id' => $id], $update_data);

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
