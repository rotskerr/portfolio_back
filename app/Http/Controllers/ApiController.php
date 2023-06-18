<?php

namespace App\Http\Controllers;

use App\Models\Desktop;
use App\Models\Mobile;
use App\Models\Projects;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getDesktop(){
        $desktop = Desktop::get();
        return response()->json($desktop,200, [], JSON_UNESCAPED_UNICODE);

    }
    public function getMobile(){
        $mobile = Mobile::get();
        return response()->json($mobile,200, [], JSON_UNESCAPED_UNICODE);

    }

    public function getProjects(){
        $project = Projects::get();
        return response()->json($project,200, [], JSON_UNESCAPED_UNICODE);

    }
}
