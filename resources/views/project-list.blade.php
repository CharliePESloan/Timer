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
            <li>
                {{ $project->description }}
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
