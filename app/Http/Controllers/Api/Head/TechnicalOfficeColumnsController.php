<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOfficeColumn;
use App\Models\TechnicalOfficeColumnSet;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficeColumnsController extends Controller
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

        if ($params['column_name']) {
            $where[] = ['column_name', 'like', '%' . $params['column_name'] . '%'];
        }

        if ($params['title']) {
            $where[] = ['title', 'like', '%' . $params['title'] . '%'];
        }

        $where[] = ['office_id', '=', $this->staff->office['office_id']];

        $office_columns = TechnicalOfficeColumn::where($where)->paginate(10);

        foreach ($office_columns as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                if ($file['storage'] == 0) {
                    $url = Storage::disk('public')->url($file['file_url']);
                } elseif ($file['storage'] == 1) {
                    $url = $file['file_url'];
                }
            }
            $value['url'] = $url;

            $column_set = TechnicalOfficeColumnSet::find($value['column_id']);

            $value['column_type_name'] = $column_set['type'] == 0 ? '图文或视频' : '仅图';
        }

        return responder()->success($office_columns);
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

        $column_set = TechnicalOfficeColumnSet::find($params['column_id']);

        $insert_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'column_id' => $params['column_id'],
            'column_name' => $column_set['name'],
            'title' => $params['title'],
            'file_id' => $params['img'] ?? 0,
            'content' => $params['content'] ?? '',
            'release_time' => strtotime($params['release_time']),
            'sort' => $params['sort'] ?? 0,
        ];

        TechnicalOfficeColumn::create($insert_data);

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
        $office_column = TechnicalOfficeColumn::find($id);

        $file = UploadFile::find($office_column['file_id']);
        $url = '';
        if ($file) {
            if ($file['storage'] == 0) {
                $url = Storage::disk('public')->url($file['file_url']);
            } elseif ($file['storage'] == 1) {
                $url = $file['file_url'];
            }
        }
        $office_column->url = $url;

        return responder()->success($office_column);
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

        $column_set = TechnicalOfficeColumnSet::find($params['column_id']);

        $update_data = [
            'office_id' => $this->staff->office['office_id'],
            'office_name' => $this->staff->office['office_name'],
            'column_id' => $params['column_id'],
            'column_name' => $column_set['name'],
            'title' => $params['title'],
            'file_id' => $params['img'] ?? 0,
            'content' => $params['content'] ?? '',
            'release_time' => strtotime($params['release_time']),
            'sort' => $params['sort'] ?? 0,
        ];

        TechnicalOfficeColumn::updateOrCreate(['id' => $id], $update_data);

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
