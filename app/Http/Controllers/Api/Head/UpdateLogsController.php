<?php

namespace App\Http\Controllers\Api\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            [
                'content' => '升级element plus，后台编辑预览优化等等',
                'timestamp' => '2022-02-15',
            ],
            [
                'content' => '员工发文上传文件加限制，列表倒序，文章样式修改等等',
                'timestamp' => '2022-02-14',
            ],
            [
                'content' => '各个模块编辑后为待审核优化，代码优化，医院概况、新闻动态测试优化等等',
                'timestamp' => '2022-02-09',
            ],
            [
                'content' => '后台加员工文件管理，员工文件表加字段优化等等',
                'timestamp' => '2022-02-09',
            ],
            [
                'content' => '后台管理员功能测试，菜单优化，前端token失效清除优化，前台加我的云盘功能，升级element-plus等等',
                'timestamp' => '2022-02-07',
            ],
            [
                'content' => '员工管理，角色管理，权限管理，优化等等',
                'timestamp' => '2022-02-05',
            ],
            [
                'content' => '患者服务，党建之窗，人才招聘，员工之声，搜索等等',
                'timestamp' => '2022-02-04',
            ],
            [
                'content' => '医院概况，新闻动态，科室介绍，专家介绍，科研教学等等',
                'timestamp' => '2022-02-03',
            ],
            [
                'content' => '注册登录，邮箱验证码登录，医院简介，领导团队',
                'timestamp' => '2022-02-02',
            ],
            [
                'content' => '前端开始对接接口，首页对接等等',
                'timestamp' => '2022-02-01',
            ],
            [
                'content' => '专家介绍，科研动态，患者服务，党建之窗，人才招聘，员工之声，优化等等',
                'timestamp' => '2022-01-31',
            ],
            [
                'content' => '科室设置（科室门诊，科室特色医疗，科室图片，科室健康科普），加搜索等等',
                'timestamp' => '2022-01-30',
            ],
            [
                'content' => '科室设置（科室动态，科室医生），科室门诊思考建表等等',
                'timestamp' => '2022-01-29',
            ],
            [
                'content' => '新闻动态加附件功能，上传文件记录文件大小兆，科室设置（科室列表，科室介绍）等等',
                'timestamp' => '2022-01-28',
            ],
            [
                'content' => '了解所需阿里云服务器，新闻动态（医院新闻、医院公告、视频新闻）',
                'timestamp' => '2022-01-27',
            ],
            [
                'content' => '领导团队，医院文化，历史沿革，历任院长，历史照片，组织机构，开发中问题解决处理',
                'timestamp' => '2022-01-26',
            ],
            [
                'content' => '菜单管理完善，首页轮播图，修改密码，退出登录，医院简介',
                'timestamp' => '2022-01-25',
            ],
            [
                'content' => '部署我服务器，后台管理员管理模块，菜单管理部分',
                'timestamp' => '2022-01-24',
            ],
            [
                'content' => '前后端登录jwt、基础处理等等',
                'timestamp' => '2022-01-23',
            ],
            [
                'content' => '服务器问题：docker-compose和MySQL导致内存溢出解决，后端接口仓库搭，后台部署自己服务器',
                'timestamp' => '2022-01-21',
            ],
            [
                'content' => '前端fix，后台前端建代码仓库、前端框架搭建，一些问题优化',
                'timestamp' => '2022-01-20',
            ],
            [
                'content' => '前端架构思考，前端首页修改，生产医院ico，图片存储本地，图片待ps操作，轮播图图片待后端接口',
                'timestamp' => '2022-01-19',
            ],
        ];

        return responder()->success($data);
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
