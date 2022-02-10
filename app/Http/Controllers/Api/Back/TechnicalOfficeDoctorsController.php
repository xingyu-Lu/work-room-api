<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeDoctor;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficeDoctorsController extends Controller
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

        $news = TechnicalOfficeDoctor::where($where)->orderBy('id', 'desc')->paginate(10);

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

        $office_id = $params['office_id'];

        $office = TechnicalOffice::where('id', $office_id)->first();

        $params['office_name'] = $office['name'];

        TechnicalOfficeDoctor::create($params);

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
        $doctor = TechnicalOfficeDoctor::find($id);

        $file = UploadFile::find($doctor['file_id']);

        $url = '';

        if ($file) {
            $url = Storage::disk('public')->url($file['file_url']);
        }

        $doctor->url = $url;

        return responder()->success($doctor);
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

        $office_id = $params['office_id'];

        $office = TechnicalOffice::where('id', $office_id)->first();

        $params['office_name'] = $office['name'];

        $params['status'] = 0;

        TechnicalOfficeDoctor::updateOrCreate(['id' => $id], $params);

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

        TechnicalOfficeDoctor::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
