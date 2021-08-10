@include('components.script', ['path' => 'confirm-message'])

<h1>Projects</h1>
<ul class="project-list">
    @foreach($projects as $project)
        <li class="project">
            <div class="name">
                <a href="{{ url('project-view/'.$project->id) }}">
                    {{ $project->name }}
                </a>
            </div>
        </li>
        <ul>
            @if(isset($project['description']) && strlen($project->description) > 0)
            <li>
                {{ $project->description }}
            </li>
            @endif
            <li>
                <form action="{{ url("delete-project/".$project->id) }}" method="get" data-confirm-message="Delete this project?">
                    @csrf
                    <input type="submit" value="Delete">
                </form>
            </li>
        </ul>
    @endforeach
</ul>

<h1>Create Project</h1>
<form action="create-project" method="post">
    @csrf
    <div>
        <label for="name">Name:</label>
    </div>
    <div>
        <input id="name" name="name" type="text">
    </div>
    <div>
        <label for="description">Description:</label>
    </div>
    <div>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <button type="submit">Create</button>
    </div>
</form>
