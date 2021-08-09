<script>
    const totalTime = {{ $total_time }};
    const startedAt = {{ isset($project->timer_started_at) ? $project->timer_started_at : 'null' }};
</script>
@include('components.script', ['path' => 'project-view'])

<div>
    <form action="{{ route('project-list') }}">
        <button type="submit">Back</button>
    </form>
</div>
<div class="project">
    <div class="name">
        {{ $project->name }}
    </div>
    <div class="total-time">
        {{ $total_time }}
    </div>
    <div class="timer-started-at">
        {{ $project->timer_started_at }}
    </div>
</div>
<div class="controls">
    @if(isset($project->timer_started_at))
        <div>
            <form class="stop-timing" action="{{ url('stop-timing/'.$project->id) }}" method="post">
                @csrf
                <input name="time" type="hidden">
                <button type="submit">Stop Timing</button>
            </form>
        </div>
    @else
        <div>
            <form class="start-timing" action="{{ url('start-timing/'.$project->id) }}" method="post">
                @csrf
                <input name="time" type="hidden">
                <button type="submit">Start Timing</button>
            </form>
        </div>
    @endif
</div>
