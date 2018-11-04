@extends('layout.app')

@section('content')
    @include('includes.message')
    <div class="row">
        <div class="col s10 offset-s1 card">
            <div class="row ">
                @if($user->admin->type == 1)
                    <a href="/dashboard">
                        <div class="col s3 center-align teal  white-text">
                            <h6>Home</h6>
                        </div>
                    </a>
                    <a href="{{route('settings')}}">
                        <div class="col s3 center-align lighten-1 teal white-text">
                            <h6>Settings</h6>
                        </div>
                    </a>
                    <a href="{{route('adminsettings')}}">
                        <div class="col s3 center-align teal white-text">
                            <h6>admin settings</h6>
                        </div>
                    </a>
                    <a href="{{route('logout')}}">
                        <div class="col s3 center-align teal white-text">
                            <h6>Logout</h6>
                        </div>
                    </a>
                @else
                    <a href="/dashboard">
                        <div class="col s4 center-align teal  white-text">
                            <h6>Home</h6>
                        </div>
                    </a>
                    <a href="{{route('settings')}}">
                        <div class="col s4 center-align teal lighten-1 white-text">
                            <h6>Settings</h6>
                        </div>
                    </a>
                    <a href="{{route('logout')}}">
                        <div class="col s4 center-align teal white-text">
                            <h6>Logout</h6>
                        </div>
                    </a>
                @endif
            </div>
            <div class="row section center-align">
                    @if(count($piggy) > 0)
                        @foreach($piggy as $pig)

                                <div class="row mt-4 mb-4">

                                    <div class="col s4">
                                    <h6>{{$pig->name}}</h6>
                                </div>
                                <div class="col s4 ">
                                    <form method="POST" action="{{route('update_settings')}}" style="display: inline;">
                                        @csrf
                                        <div class="switch">
                                            <label>
                                                Disable
                                                    <input type="hidden" name="piggy_id" value="{{$pig->id}}">
                                                    <input type="checkbox"  @if($pig->status == 1) checked @endif onClick="submit();" name="status">
                                                    <span class="lever" style="background-color: {{$pig->color}} !important;"></span>
                                                Enable
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="col s4">
                                    <div class="input-field col s3 offset-s1">
                                        <form method="POST" action="{{route('destroy_settings')}}">
                                            @csrf
                                            <input type="submit" class="waves-effect red waves-light btn" value="delete">
                                            <input type="hidden" name="id" value="{{$pig->id}}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    @else
                    <div class="row section">
                        <h4>No piggies with settings were found</h4>
                    </div>
                    @endif
            </div>
        </div>
    </div>
    @endsection