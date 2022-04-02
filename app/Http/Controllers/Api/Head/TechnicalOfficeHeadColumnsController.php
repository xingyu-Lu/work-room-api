<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOfficeColumn;
use App\Models\TechnicalOfficeColumnSet;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TechnicalOfficeHeadColumnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('h-api')->user();

        $params = $request->all();

        //分页条件
        $current_page = $params['page'] ?? 1;
        $perPage = $params['page_size'] ?? 10;
        $path = Paginator::resolveCurrentPath();

        $office_columns = $data = $where = [];

        $where[] = ['office_id', '=', $params['office_id']];

        $where[] = ['column_id', '=', $params['column_id']];

        $office_column_set = TechnicalOfficeColumnSet::where('id', $params['column_id'])->first();

        if ($office_column_set['type'] == 0) {
            if ($user) {
                $office_columns = TechnicalOfficeColumn::where($where)->whereIn('status', [0, 1]);
            } else {
                $office_columns->whereIn('status', [0]);
            }

            $office_columns = $office_columns->orderBy('id', 'desc')->paginate(20);

            foreach ($office_columns as $key => $value) {
                $file = UploadFile::find($value['file_id']);
                $url = '';
                if ($file) {
                    $url = Storage::disk('public')->url($file['file_url']);
                }
                $value['url'] = $url;

                $column_set = TechnicalOfficeColumnSet::find($value['column_id']);

                $value['column_type_name'] = $column_set['type'] == 0 ? '图文或视频' : '仅图';
            }
        }

        if ($office_column_set['type'] == 1) {
            $office_columns = TechnicalOfficeColumn::where($where);

            if ($user) {
                $office_columns->whereIn('status', [0, 1]);
            } else {
                $office_columns->whereIn('status', [0]);
            }

            $total = $office_columns->count();

            $office_columns = $office_columns->orderBy('id', 'desc')->offset(($current_page-1)*$perPage)->limit($perPage)->get()->toArray();

            foreach ($office_columns as $key => &$value) {
                $file = UploadFile::find($value['file_id']);
                $url = '';
                if ($file) {
                    $url = Storage::disk('public')->url($file['file_url']);
                }
                $value['url'] = $url;

                $column_set = TechnicalOfficeColumnSet::find($value['column_id']);

                $value['column_type_name'] = $column_set['type'] == 0 ? '图文或视频' : '仅图';
            }

            unset($value);

            $office_columns = array_chunk($office_columns, 4);

            $office_columns = new LengthAwarePaginator($office_columns, $total, $perPage, $current_page, [
                'path' => $path,
            ]);
        }

        return responder()->success($office_columns);
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
        $column = TechnicalOfficeColumn::find($id);

        $column->num += 1;

        $column->save();

        $file = UploadFile::find($column['file_id']);
        $url = '';
        if ($file) {
            $url = Storage::disk('public')->url($file['file_url']);
        }
        $column['url'] = $url;

        return responder()->success($column);
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
