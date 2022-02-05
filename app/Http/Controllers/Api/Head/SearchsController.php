<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\Job;
use App\Models\News;
use Illuminate\Http\Request;

class SearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $type = $params['type'];
        $keyword = $params['keyword'];

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $search = [];

        // 新闻
        if ($type == 0) {
            $search = News::whereIn('status', $where_arr)->where('type', 0)->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%');
            })->paginate(10);

            foreach ($search as $key => $value) {
                $value['url'] = 'yyxw_detail?id=' . $value['id'];
            }
        }

        // 公告
        if ($type == 1) {
            $search = News::whereIn('status', $where_arr)->where('type', 1)->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%');
            })->paginate(10);
            foreach ($search as $key => $value) {
                $value['url'] = 'yygg_detail?id=' . $value['id'];
            }
        }

        // 专家
        if ($type == 2) {
            $search = Expert::whereIn('status', $where_arr)->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('excel', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%');
            })->paginate(10);
            foreach ($search as $key => $value) {
                $value['url'] = 'zjjs_detail?id=' . $value['id'];
            }
        }

        // 招聘
        if ($type == 3) {
            $search = Job::whereIn('status', $where_arr)->where('type', 0)->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')->orWhere('content', 'like', '%' . $keyword . '%');
            })->paginate(10);
            foreach ($search as $key => $value) {
                $value['url'] = 'zpxx_detail?id=' . $value['id'];
            }
        }

        return responder()->success($search);
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
}
