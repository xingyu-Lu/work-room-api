<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Models\FileEmployee;
use Illuminate\Http\Request;

class FileEmployeesController extends Controller
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
        if (isset($params['file_name']) && $params['file_name']) {
            $where[] = [
                'file_name', 'like', '%' . $params['file_name'] . '%'
            ];
        }
        if (isset($params['staff_name']) && $params['staff_name']) {
            $where[] = [
                'staff_name', 'like', '%' . $params['staff_name'] . '%'
            ];
        }

        $file = FileEmployee::with('files')->where($where)->paginate(10);

        return responder()->success($file);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        FileEmployee::updateOrCreate(['id' => $id], ['status' => $status]);

        return responder()->success();
    }
}
