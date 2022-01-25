<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\Rotate;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RotatesController extends Controller
{
    public function srclist(Request $request)
    {
        $rotates = Rotate::get();

        $pre_path = $request->server('REQUEST_SCHEME') . '://' .$request->server('HTTP_HOST');

        $img_arr = [];

        foreach ($rotates as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = $pre_path . Storage::url($file['file_url']);

            $img_arr[] = $url;
        }

        return responder()->success($img_arr);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rotates = Rotate::get();

        $pre_path = $request->server('REQUEST_SCHEME') . '://' .$request->server('HTTP_HOST');

        foreach ($rotates as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = $pre_path . Storage::url($file['file_url']);
            $value['url'] = $url;
        }

        return responder()->success($rotates);
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

        Rotate::create($params);

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

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        Rotate::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
