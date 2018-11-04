@extends('layout.app')

@section('content')
    @include('includes.message')
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
            <form class="col s12" method="POST" action="/login/attempt">
                @csrf
                <div class="input-field col s12 mt-4">
                    <input id="email" type="text" class="validate" name="email">
                    <label for="email" >Email</label>
                </div>
                <div class="input-field col s12 mt-4">
                    <input id="password" type="text" class="validate" name="password">
                    <label for="password">Wachtwoord</label>
                </div>
                <div class="input-field col s12 mt-3">
                    <input type="submit" class="btn waves-effect col s12 waves-light" name="submit" value="login">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection