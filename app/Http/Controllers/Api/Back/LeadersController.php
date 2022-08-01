<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadersController extends Controller
{
    public function srclist(Request $request)
    {
        $rotates = Leader::orderBy('sort', 'asc')->get();

        $img_arr = [];

        foreach ($rotates as $key => $value) {
            $file = UploadFile::find($value['file_id']);

            if ($file) {
                if ($file['storage'] == 0) {
                    $url = Storage::disk('public')->url($file['file_url']);
                } elseif ($file['storage'] == 1) {
                    $url = $file['file_url'];
                }
            } else {
                $url = '';
            }

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
        $leaders = Leader::orderBy('sort', 'asc')->get();

        foreach ($leaders as $key => $value) {
            $file = UploadFile::find($value['file_id']);

            if ($file) {
                if ($file['storage'] == 0) {
                    $url = Storage::disk('public')->url($file['file_url']);
                } elseif ($file['storage'] == 1) {
                    $url = $file['file_url'];
                }
            } else {
                $url = '';
            }
            
            $value['url'] = $url;
        }

        return responder()->success($leaders);
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

        Leader::create($params);

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
        $leader = Leader::find($id);

        $file = UploadFile::find($leader['file_id']);

        if ($file) {
            if ($file['storage'] == 0) {
                $url = Storage::disk('public')->url($file['file_url']);
            } elseif ($file['storage'] == 1) {
                $url = $file['file_url'];
            }
        }

        $leader->url = $url;

        return responder()->success($leader);
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

        $params['status'] = 0;

        Leader::updateOrCreate(['id' => $id], $params);

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
        
    }

    public function status(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        $status = $params['status'];

        Leader::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
