<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        //分页条件
        $current_page = $params['page'] ?? 1;
        $perPage = $params['page_size'] ?? 10;
        $path = Paginator::resolveCurrentPath();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $where = [];
        if ($params['office_id']) {
            $where[] = [
                'office_id', '=', $params['office_id']
            ];
        }

        $expert = Expert::whereIn('status', $where_arr)->where($where);

        $total = $expert->count();

        $expert = $expert->orderBy('sort', 'asc')->offset(($current_page-1)*$perPage)->limit($perPage)->get()->toArray();

        foreach ($expert as $key => &$value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;

            $value['position'] = explode(',', $value['position']);
            $value['professional'] = explode(',', $value['professional']);
        }

        $expert = array_chunk($expert, 6);

        $expert = new LengthAwarePaginator($expert, $total, $perPage, $current_page, [
            'path' => $path,
        ]);

        return responder()->success($expert);
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
    public function show(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $expert = Expert::whereIn('status', $where_arr)->where('id', $params['id'])->first();

        $file = UploadFile::find($expert['file_id']);
        $url = '';
        if ($file) {
            $url = Storage::disk('public')->url($file['file_url']);
        }
        $expert['img_url'] = $url;

        return responder()->success($expert);
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
}
