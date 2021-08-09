<form action="{{ route('login-post') }}" method="post">
    @csrf
    <div>
        <label for="email">Email:</label>
    </div>
    <div>
        <input id="email" name="email" type="email">
    </div>
    <div>
        <label for="password">Password:</label>
    </div>
    <div>
        <input id="password" name="password" type="password">
    </div>
    <div>
        <button type="submit">Log In</button>
    </div>
</form>
