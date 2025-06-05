@extends('layouts.guest')

@section('content')
<div class="auth-logo">
    <a href="{{ route('home') }}">E-Shop</a>
</div>

<h2 style="text-align: center; margin-bottom: 1.5rem;">Login</h2>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    
    <div class="form-checkbox">
        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember">Remember me</label>
    </div>
    
    <button type="submit" class="btn">Log in</button>
    
    <div class="auth-links">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        @endif
        
        @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
    </div>
</form>
@endsection