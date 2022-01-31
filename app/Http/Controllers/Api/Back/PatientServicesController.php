<?php

namespace App\Http\Controllers\Api\Back;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\PatientService;
use Illuminate\Http\Request;

class PatientServicesController extends Controller
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

        $news = PatientService::where($where)->orderBy('id', 'desc')->paginate(10);

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

        if (in_array($params['type'], [0, 1, 5, 6, 7])) {
             $patient = PatientService::where('type', $params['type'])->first();

            if ($patient) {
                throw new BaseException(['msg' => '已添加，不可新增']);
            }
        }

        $params['release_time'] = strtotime($params['release_time']);

        PatientService::create($params);

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
        $dynamic = PatientService::find($id);

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

        if (in_array($params['type'], [0, 1, 5, 6, 7])) {
             $patient = PatientService::where('type', $params['type'])->first();

            if ($patient) {
                throw new BaseException(['msg' => '已添加，不可新增']);
            }
        }

        $params['release_time'] = strtotime($params['release_time']);

        PatientService::updateOrCreate(['id' => $id], $params);

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

        PatientService::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
