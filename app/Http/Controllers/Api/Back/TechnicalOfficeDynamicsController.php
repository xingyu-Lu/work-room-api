<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeDynamic;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficeDynamicsController extends Controller
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

        if ($params['office_name']) {
            $where[] = ['office_name', 'like', '%' . $params['office_name'] . '%'];
        }

        $news = TechnicalOfficeDynamic::where($where)->orderBy('status', 'asc')->orderBy('id', 'desc')->paginate(30);

        foreach ($news as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
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

        $office_id = $params['office_id'];

        $office = TechnicalOffice::where('id', $office_id)->first();

        $params['office_name'] = $office['name'];

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
            $url = Storage::disk('public')->url($file['file_url']);
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

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        TechnicalOfficeDynamic::updateOrCreate(['id' => $id], ['status' => $status]);

        $dynamic = TechnicalOfficeDynamic::find($id);

        // 审核通过的自动同步院新闻
        if ($status == 1) {
            $syn_data = [
                'title' => $dynamic['title'],
                'file_id' => $dynamic['file_id'],
                'content' => $dynamic['content'],
                'release_time' => strtotime($dynamic['release_time']),
                'status' => 1,
                'type' => 0,
            ];

            News::updateOrCreate(['office_article_id' => $id], $syn_data);
        }

        return responder()->success();
    }
}
