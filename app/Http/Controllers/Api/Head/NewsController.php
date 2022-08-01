<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function yyxw(Request $request)
    {
        $params = $request->all();
        $type = $params['type'];

        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $news = News::whereIn('status', $where_arr)->where('type', $type)->orderBy('release_time', 'desc')->orderBy('id', 'desc')->paginate(10);

        foreach ($news as $key => $value) {
            $file = UploadFile::find($value['file_id']);
            $url = '';
            if ($file) {
                if ($file['storage'] == 0) {
                    $url = Storage::disk('public')->url($file['file_url']);
                } elseif ($file['storage'] == 1) {
                    $url = $file['file_url'];
                }
            }
            $value['img_url'] = $url;

            $value['strip_content'] = str_replace('&nbsp;', '', mb_substr(strip_tags($value['content']), 0, 100)) . '...';
        }

        return responder()->success($news);
    }

    public function yyxw_detail(Request $request)
    {
        $where_arr = [];

        $user = auth('h-api')->user();
        if ($user) {
            $where_arr = [0, 1];    
        } else {
            $where_arr = [1];
        }

        $params = $request->all();

        $id = $params['id'];

        $news = News::where('id', $id)->whereIn('status', $where_arr)->first();

        $news->num += 1;

        $news->save();

        return responder()->success($news);
    }
}
