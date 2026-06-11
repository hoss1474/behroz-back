<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * نمایش همه پروژه‌ها
     */
    public function index()
    {
        $projects = Project::latest()->get();


        return response()->json([
            'status' => true,
            'count'  => $projects->count(),
            'data'   => $projects,
        ]);
    }

    /**
     * نمایش یک پروژه
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $project,
        ]);
    }
}
