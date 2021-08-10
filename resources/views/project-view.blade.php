<script>
    const totalTime = {{ $total_time }};
    const startedAt = {{ isset($project->timer_started_at) ? $project->timer_started_at : 'null' }};
</script>
@include('components.script', ['path' => 'project-view'])
@include('components.script', ['path' => 'confirm-message'])


<div>
    <form action="{{ route('project-list') }}">
        <button type="submit">Back</button>
    </form>
</div>


<div class="project">
    <div class="name">
        Project: {{ $project->name }}
    </div>
    <div class="total-time">
        Total Time: <span>{{ $hours }}h {{ $minutes }}m {{ $seconds }}s</span>
    </div>
{{--    <div class="timer-started-at">--}}
{{--        Started at: <span>{{ $project->timer_started_at }}</span>--}}
{{--    </div>--}}
{{--    <div class="time-now">--}}
{{--        Time Now: <span></span>--}}
{{--    </div>--}}
</div>


<div class="controls">
    @if(isset($project->timer_started_at))

        <div>
            <form class="stop-timing" action="{{ url('stop-timing/'.$project->id) }}" method="post">
                @csrf
                <button type="submit">Stop Timing</button>
            </form>
        </div>

        <div>
            <form class="cancel-timer" action="{{ url('cancel-timer/'.$project->id) }}" method="get" data-confirm-message="Cancel current timer?">
                @csrf
                <button type="submit">Cancel Timer</button>
            </form>
        </div>

    @else

        <div>
            <form class="start-timing" action="{{ url('start-timing/'.$project->id) }}" method="post">
                @csrf
                <button type="submit">Start Timing</button> <label for="date time">Stop at:</label> <input id="date" name="date" type="date"><input id="time" name="time" type="time">
            </form>
        </div>

        @if($has_segments)
            <div>
                <form class="undo-segment" action="{{ url('undo-segment/'.$project->id) }}" method="get" data-confirm-message="Undo the last segment?">
                    @csrf
                    <button type="submit">Undo Segment</button>
                    Delete? <input name="delete" type="checkbox" checked>
                </form>
            </div>
        @endif

        @if($total_time > 0)

            <div>
                <form class="reset-total-delete" action="{{ url('reset-total/'.$project->id) }}" method="post" data-confirm-message="Reset your total to zero? You have worked {{ $hours }}h {{ $minutes }}m {{ $seconds }}s">
                    @csrf
                    <button type="submit">Reset Total</button>
                    Delete? <input name="delete" type="checkbox">
                </form>
            </div>

        @endif

        <div>
            <form class="add-time" action="{{ url('add-time/'.$project->id) }}" method="post">
                @csrf
                <div><label for="time">Time in seconds:</label></div>
                <div><input id="time" name="time" type="number" step="1"></div>
                <div><button type="submit">Add Time</button></div>
            </form>
        </div>

    @endif
</div>
