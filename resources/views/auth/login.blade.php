@extends("layouts.login")

@section("content")
<form method="POST" action="{{ url('login') }}" class="form-guest">
    <div class="form-group">
        <label for="email" class="sr-only">Email address</label>
        <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email address" required autofocus>
    </div>
    <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-lg btn-block btn-secondary" type="submit">Sign In</button>
</form>
@if ($errors->any())
<div class="alert alert-danger mt-2">{{ $errors->first() }}</div>
@endif
</div>
@endsection

