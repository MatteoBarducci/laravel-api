<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {
        // $posts = Post::all();
        $projects = Project::all();
        // dd($posts);

        return response()->json([
            'success' => true,
            'results' => $projects
        ]);
    }
}
