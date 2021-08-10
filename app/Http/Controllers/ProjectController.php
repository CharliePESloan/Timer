<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function projectList()
    {
        $projects = Auth::user()->projects;
        return view('project-list', compact('projects'));
    }

    public function projectView($id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $times = $project->segments->pluck('time')->toArray();
            $total_time = array_sum($times);

            $has_segments = count($times) > 0;

            $hours = (int)($total_time / 60 / 60);
            $minutes = (int)(($total_time - $hours * 60 * 60) / 60);
            $seconds = (int)(($total_time - $hours * 60 * 60 + $minutes * 60) / 60);

            return view('project-view', compact('project', 'total_time', 'has_segments', 'hours', 'minutes', 'seconds'));
        }
    }

    public function createProject(Request $request)
    {
        $requestData = $request->all();
        unset($requestData['_token']);
        unset($requestData['_method']);
        $requestData['user_id'] = Auth::id();

        $project = Project::create($requestData);
//        $id = $project->id;
//        return Redirect::to('project-view/'.$id);
        return Redirect::back();
    }

    public function deleteProject($id)
    {
        if (Project::findOrFail($id)->user_id == Auth::id())
        {
            Project::destroy([$id]);
        }

        return Redirect::back();
    }

    public function startTiming(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $date = $request->get('date');
            $time = $request->get('time');
            $project->timer_started_at = time();
            if (isset($date) && isset($time) && $date != null && $time != null)
            {
                $project->stop_at = strtotime($date.' '.$time);
            }
            $project->save();
        }

        return Redirect::back();
    }

    public function stopTiming(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($project->user_id == Auth::id())
        {
            if (isset($project['timer_started_at'])) {
                if ($project->user_id == Auth::id()) {
                    $start_time = $project->timer_started_at;
                    $finish_time = time();
                    if (isset($finish_time)) {
                        if (isset($project['stop_at'])) {
                            $finish_time = min([$finish_time, $project->stop_at]);
                        }
                        $time = $finish_time - $start_time;

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
                }
            }
        }

        return Redirect::back();
    }

    public function undoSegment(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $delete = $request->get('delete');
            $last_segment = $project->segments()->orderBy('id', 'desc')->first();
            if ($last_segment)
            {
                if ($delete)
                {
                    $last_segment->delete();
                }
                else
                {
                    Segment::create([
                        'project_id' => $id,
                        'time' => -$last_segment->time,
                        'started_at' => time(),
                        'finished_at' => time(),
                    ]);
                }
            }

        }

        return Redirect::back();
    }

    public function resetTotal(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $delete = $request->get('delete');
            if ($delete)
            {
                Segment::destroy($project->segments()->pluck('id')->toArray());
            } else
            {
                $times = $project->segments()->pluck('time')->toArray();
                $total_time = array_sum($times);

                Segment::create([
                    'project_id' => $id,
                    'time' => -$total_time,
                    'started_at' => time(),
                    'finished_at' => time(),
                ]);
            }
        }

        return Redirect::back();
    }

    public function addTime(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $time = $request->get('time');

            Segment::create([
                'project_id' => $id,
                'time' => $time,
                'started_at' => time(),
                'finished_at' => time(),
            ]);
        }

        return Redirect::back();
    }

    public function cancelTimer($id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id == Auth::id())
        {
            $project->timer_started_at = null;
            $project->stop_at = null;
            $project->save();
        }

        return Redirect::back();
    }
}
