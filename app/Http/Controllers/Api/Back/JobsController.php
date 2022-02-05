<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobsController extends Controller
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

        $where[] = ['type', '=', $params['type']];

        if ($params['title']) {
            $where[] = ['title', 'like', '%' . $params['title'] . '%'];
        }

        $news = Job::where($where)->orderBy('id', 'desc')->paginate(10);

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

        if (in_array($params['type'], [1])) {
             $patient = Job::where('type', $params['type'])->first();

            if ($patient) {
                throw new BaseException(['msg' => '已添加，不可新增']);
            }
        }

        if (empty($params['title'])) {
            $params['title'] = '';
        }

        if ($params['attachment']) {
            $params['attachment_id'] = $params['attachment'];
        }

        unset($params['attachment']);

        $params['release_time'] = strtotime($params['release_time']);

        Job::create($params);

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
        $dynamic = Job::find($id);

        $attachment_ids = explode(',', $dynamic['attachment_id']);
        $attachment = [];

        foreach ($attachment_ids as $key => $value) {
            $file = UploadFile::find($value);
            if ($file) {
                $attachment[] = [
                    'name' => Storage::disk('public')->url($file['file_url']),
                    'url' => Storage::disk('public')->url($file['file_url'])
                ];
            }
        }

        $dynamic->attachment = $attachment;

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

        if (in_array($params['type'], [1])) {
             $patient = Job::where('type', $params['type'])->first();

            if ($patient) {
                throw new BaseException(['msg' => '已添加，不可新增']);
            }
        }

        if (empty($params['title'])) {
            $params['title'] = '';
        }

        if ($params['attachment']) {
            $params['attachment_id'] = $params['attachment'];
        }

        unset($params['attachment']);

        $params['release_time'] = strtotime($params['release_time']);

        Job::updateOrCreate(['id' => $id], $params);

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

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        Job::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
