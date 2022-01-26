<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\HistoryLeader;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryLeadersController extends Controller
{
    public function srclist()
    {
        $history_leaders = HistoryLeader::orderBy('sort', 'asc')->get();

        $img_arr = [];

        foreach ($history_leaders as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = Storage::disk('public')->url($file['file_url']);

            $img_arr[] = $url;
        }

        return responder()->success($img_arr);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $history_leaders = HistoryLeader::orderBy('sort', 'asc')->get();

        foreach ($history_leaders as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = Storage::disk('public')->url($file['file_url']);
            $value['url'] = $url;
        }

        return responder()->success($history_leaders);
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

        $params['file_id'] = $params['img'];
        unset($params['img']);

        HistoryLeader::create($params);

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
        $history_leader = HistoryLeader::find($id);

        $file = UploadFile::find($history_leader['file_id']);

        $url = Storage::disk('public')->url($file['file_url']);

        $history_leader->url = $url;

        return responder()->success($history_leader);
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

        $params['file_id'] = $params['img'];
        unset($params['img']);

        HistoryLeader::updateOrCreate(['id' => $id], $params);

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

        HistoryLeader::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
