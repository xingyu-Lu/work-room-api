<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\PatientService;
use Illuminate\Http\Request;

class PatientServicesController extends Controller
{
    /**
     * 患者服务
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function mzlc(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        if (in_array($params['type'], [0,1,5,6,7])) {
            $service = PatientService::whereIn('status', $where_arr)->where('type', $params['type'])->first();
        } else {
            $service = PatientService::whereIn('status', $where_arr)->where('type', $params['type'])->orderBy('id', 'desc')->paginate(10);
        }

        return responder()->success($service);
    }

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

        $service = PatientService::whereIn('status', $where_arr)->where('id', $params['id'])->first();

        $service->num += 1;

        $service->save();

        return responder()->success($service);
    }
}
