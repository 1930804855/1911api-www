<?php

namespace App\Http\Controllers\Mstore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 首页方法
     */
    public function index(){
        //渲染视图
        return view('mstore/index');
    }
}
