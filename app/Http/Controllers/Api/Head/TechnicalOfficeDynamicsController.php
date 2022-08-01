<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeDynamic;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficeDynamicsController extends Controller
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

        if ($params['title']) {
            $where[] = ['title', 'like', '%' . $params['title'] . '%'];
        }

        $where[] = [
            'office_id', '=', $this->staff->office['office_id']
        ];

        $news = TechnicalOfficeDynamic::where($where)->orderBy('id', 'desc')->paginate(10);

        foreach ($news as $key => $value) {
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
        }

        return responder()->success($news);
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

        if ($params['img']) {
            $params['file_id'] = $params['img'];
        }

        unset($params['img']);

        $params['release_time'] = strtotime($params['release_time']);

        $office_id = $this->staff->office['office_id'];

        $office = TechnicalOffice::where('id', $office_id)->first();

        $params['office_name'] = $office['name'];

        $params['office_id'] = $this->staff->office['office_id'];

        $params['status'] = 0;

        TechnicalOfficeDynamic::create($params);

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
        $dynamic = TechnicalOfficeDynamic::find($id);

        $file = UploadFile::find($dynamic['file_id']);

        $url = '';

        if ($file) {
            if ($file['storage'] == 0) {
                $url = Storage::disk('public')->url($file['file_url']);
            } elseif ($file['storage'] == 1) {
                $url = $file['file_url'];
            }
        }

        $dynamic->url = $url;

        return responder()->success($dynamic);
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

        if ($params['img']) {
            $params['file_id'] = $params['img'];
        }

        unset($params['img']);

        $params['release_time'] = strtotime($params['release_time']);
        $params['status'] = 0;

        TechnicalOfficeDynamic::updateOrCreate(['id' => $id], $params);

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
