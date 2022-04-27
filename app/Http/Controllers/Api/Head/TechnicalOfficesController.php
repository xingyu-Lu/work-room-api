<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeDoctor;
use App\Models\TechnicalOfficeDynamic;
use App\Models\TechnicalOfficeFeature;
use App\Models\TechnicalOfficeHealthScience;
use App\Models\TechnicalOfficeIntroduce;
use App\Models\TechnicalOfficeOutpatient;
use App\Models\TechnicalOfficePic;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalOfficesController extends Controller
{
    public function info(Request $request)
    {
        $params = $request->all();

        $info = TechnicalOffice::find($params['id']);

        return responder()->success($info);
    }

    public function list()
    {
        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $office = TechnicalOffice::whereIn('status', $where_arr)->orderBy('index', 'asc')->get();

        return responder()->success($office);
    }

    public function kejs(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $where = $office = [];

        if ($params['index'] != 'all') {
            $where[] = [
                'index', '=', $params['index']
            ];
        }

        if ($params['index'] == 'all') {
            $office_0 = TechnicalOffice::whereIn('status', $where_arr)->where($where)->where('type', 0)->orderBy('index', 'asc')->get()->toArray();
            $office_0 = array_chunk($office_0, 6);

            $office_1 = TechnicalOffice::whereIn('status', $where_arr)->where($where)->where('type', 1)->orderBy('index', 'asc')->get()->toArray();
            $office_1 = array_chunk($office_1, 6);

            $office_2 = TechnicalOffice::whereIn('status', $where_arr)->where($where)->where('type', 2)->orderBy('index', 'asc')->get()->toArray();
            $office_2 = array_chunk($office_2, 6);

            $office['office_0'] = $office_0;
            $office['office_1'] = $office_1;
            $office['office_2'] = $office_2;
            $office['index'] = $params['index'];
        } else {
            $office = TechnicalOffice::whereIn('status', $where_arr)->where($where)->orderBy('index', 'asc')->get()->toArray();
            $office['search'] = array_chunk($office, 6);
            $office['index'] = $params['index'];
        }

        return responder()->success($office);
    }

    public function ksjs_detail(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $introduce = TechnicalOfficeIntroduce::whereIn('status', $where_arr)->where('office_id', $params['id'])->first();

        return responder()->success($introduce);
    }

    public function ksdt(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeDynamic::whereIn('status', $where_arr)->where('office_id', $params['id'])->paginate(10);

        foreach ($dynamic as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;

            $value['strip_content'] = trim(mb_substr(strip_tags($value['content']), 0, 100), '&nbsp;');
        }

        return responder()->success($dynamic);
    }

    public function ksdt_detail(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeDynamic::whereIn('status', $where_arr)->where('id', $params['id'])->first();

        $dynamic->num += 1;

        $dynamic->save();

        return responder()->success($dynamic);
    }

    public function ksys(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $doctor = TechnicalOfficeDoctor::whereIn('status', $where_arr)->where('office_id', $params['id'])->orderBy('sort', 'asc')->get()->toArray();

        foreach ($doctor as $key => &$value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['professional'] = explode(',', $value['professional']);
            $value['img_url'] = $url;
        }
        unset($value);

        $doctor = array_chunk($doctor, 6);

        return responder()->success($doctor);
    }

    public function ksys_detail(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $doctor = TechnicalOfficeDoctor::whereIn('status', $where_arr)->where('id', $params['id'])->first();
        $file = UploadFile::find($doctor['file_id']);
        $url = '';
        if ($file) {
            $url = Storage::disk('public')->url($file['file_url']);
        }
        $doctor->img_url = $url;


        return responder()->success($doctor);
    }

    public function ksmz(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $where = [];

        $where[] = [
            'yq_type', '=', $params['yq_type']
        ];

        if (isset($params['id']) && $params['id'] && $params['id'] != 39) {
            $where[] = [
                'office_id', '=', $params['id']
            ];
        }

        $outpatient = TechnicalOfficeOutpatient::whereIn('status', $where_arr)->where($where)->orderBy('office_id', 'asc')->orderBy('type', 'asc')->get();

        return responder()->success($outpatient);
    }

    public function tsyl(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeFeature::whereIn('status', $where_arr)->where('office_id', $params['id'])->paginate(10);

        foreach ($dynamic as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;

            $value['strip_content'] = mb_substr(strip_tags($value['content']), 30, 100);
        }

        return responder()->success($dynamic);
    }

    public function tsyl_detail(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeFeature::whereIn('status', $where_arr)->where('id', $params['id'])->first();

        $dynamic->num += 1;

        $dynamic->save();

        return responder()->success($dynamic);
    }

    public function kstp(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $pic = TechnicalOfficePic::whereIn('status', $where_arr)->where('office_id', $params['id'])->get()->toArray();

        foreach ($pic as $key => &$value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;
        }
        unset($value);

        $pic = array_chunk($pic, 4);

        return responder()->success($pic);
    }

    public function jkkp(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeHealthScience::whereIn('status', $where_arr)->where('office_id', $params['id'])->paginate(10);

        foreach ($dynamic as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;

            $value['strip_content'] = mb_substr(strip_tags($value['content']), 30, 100);
        }

        return responder()->success($dynamic);
    }

    public function jkkp_detail(Request $request)
    {
        $params = $request->all();

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $dynamic = TechnicalOfficeHealthScience::whereIn('status', $where_arr)->where('id', $params['id'])->first();

        $dynamic->num += 1;

        $dynamic->save();

        return responder()->success($dynamic);
    }
}
