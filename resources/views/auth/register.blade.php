@extends('layouts.guest')

@section('content')
<div class="auth-logo">
    <a href="{{ route('home') }}">E-Shop</a>
</div>

<h2 style="text-align: center; margin-bottom: 1.5rem;">Register</h2>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
    </div>
    
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
    </div>
    
    <button type="submit" class="btn">Register</button>
    
    <div class="auth-links" style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('login') }}">Already registered? Login here</a>
    </div>
</form>
@endsection