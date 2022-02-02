<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\Brief;
use App\Models\Leader;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BriefsController extends Controller
{
    public function yyjj()
    {
        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $brief = Brief::whereIn('status', $where_arr)->first();

        return responder()->success($brief);
    }

    public function ldtd()
    {
        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $leader = Leader::whereIn('status', $where_arr)->get()->toArray();

        foreach ($leader as $key => &$value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                $url = Storage::disk('public')->url($file['file_url']);
            }
            $value['img_url'] = $url;

            $value['position'] = explode(',', $value['position']);
            $value['professional'] = explode(',', $value['professional']);
        }
        unset($value);

        $leader = array_chunk($leader, 6);

        return responder()->success($leader);
    }
}
