<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RotatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // var_dump($request->server());exit;
        $pre_path = $request->server('REQUEST_SCHEME') . '://' .$request->server('HTTP_HOST') . "/storage/img/";
        $imgs = [
            [
                'url' => $pre_path. "lunbo1.png",
            ],
            [
                'url' => $pre_path. "lunbo2.png",
            ],
            [
                'url' => $pre_path. "lunbo3.png",
            ],
            [
                'url' => $pre_path. "lunbo4.png",
            ],
        ];

        return responder()->success($imgs);
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
