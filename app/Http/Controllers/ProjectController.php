<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Project;

class ProjectController extends Controller
{
    public function projectList()
    {
        $projects = Project::all();
        return view('project-list', compact('projects'));
    }

    public function projectView($id)
    {
        $project = Project::findOrFail($id);
        $times = $project->segments()->pluck('time')->toArray();
        $total_time = array_sum($times);
        return view('project-view', compact('project', 'total_time'));
    }

    public function createProject(Request $request)
    {
        $requestData = $request->all();
        unset($requestData['_token']);
        unset($requestData['_method']);
        $requestData['user_id'] = Auth::id();

        $project = Project::create($requestData);
        $id = $project->id;

        return Redirect::to('project-view/'.$id);
    }

    public function startTiming(Request $request, $id)
    {
        $time = $request->get('time');

        $project = Project::findOrFail($id);
        $project->timer_started_at = $time;
        $project->save();

        return redirect()->back();
    }

    public function stopTiming(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if (isset($project['timer_started_at']))
        {
            $start_time = $project->timer_started_at;
            $finish_time = $request->get('time');
            if (isset($project['stop_at']))
            {
                if ($finish_time < $project->stop_at)
                {
                    $finish_time = $project->stop_at;
                }
            }
            $time = $finish_time - $start_time;

            abort(418,"test".$request->get('time'));

            $segment_data = [
                'project_id' => $project->id,
                'time' => $time,
                'started_at' => $start_time,
                'finished_at' => $finish_time,
            ];
            $created_segment = Segment::create($segment_data);

            $project->timer_started_at = null;
            $project->stop_at = null;
            $project->save();
        }

        return redirect()->back();
    }
}
