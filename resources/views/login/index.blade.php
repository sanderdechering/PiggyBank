@extends('layout.app')

@section('content')
<div class="row">
    <div class="col s4 offset-s4 card">
        <div class="row">
            <a href="{{route('login')}}">
                <div class="col s6 teal lighten-1 center-align white-text ">
                    <h6>Login</h6>
                </div>
            </a>
            <a href="{{route('register')}}">
                <div class="col s6 teal center-align white-text">
                    <h6>Register</h6>
                </div>
            </a>
            <form class="col s12" action="{{route('dashboard')}}">
                <div class="input-field col s12 mt-4">
                    <input id="email" type="text" class="validate">
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12 mt-4">
                    <input id="password" type="text" class="validate">
                    <label for="password">Wachtwoord</label>
                </div>
                <div class="input-field col s12 mt-3">
                    <button class="btn waves-effect col s12 waves-light" type="submit" name="action">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection