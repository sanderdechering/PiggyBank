@extends('layout.app')

@section('content')
    <div class="row ">
        <div class="col s10 offset-s1 card">
            <div class="row ">
                @if($user->admin->type == 1)
                <a href="/dashboard">
                    <div class="col s3 center-align teal lighten-1 white-text">
                        <h6>Home</h6>
                    </div>
                </a>
                <a href="{{route('settings')}}">
                    <div class="col s3 center-align teal white-text">
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
                        <div class="col s4 center-align teal lighten-1 white-text">
                            <h6>Home</h6>
                        </div>
                    </a>
                    <a href="{{route('settings')}}">
                        <div class="col s4 center-align teal white-text">
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
            <div class="row section">
                <div class="col s3 offset-s1 center-align">
                    <h3 class="header teal-text">Balance:</h3>
                    @if($total != null )
                        <h5>€{{$total}}</h5>
                    @else
                        <h5>€00.00</h5>
                    @endif
                </div>
                <div class="col s3 offset-s1">
                    <ul>
                        @if(count($piggy) > 0)
                            @foreach($piggy as $pig)
                                <li class="valign-wrapper"><i class="small material-icons" style="color: {{$pig->color}}">fiber_manual_record</i>{{$pig->name}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col s3">
                    @if(count($Balance_total_chart) != null)
                        {!! $Balance_total_chart->render() !!}
                   @endif
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col s10 offset-s1">
        @if(count($piggy) > 0)
            @foreach($piggy as $pig )
            <div class="col s4 center-align ">
                <div class="row">
                    @if($pig->status == 1)<a href="/dashboard/{{$pig->id}}">@endif()
                        <div class="col s11 card" style="padding: 0px;">
                            <div class="col s12 white-text " style="@if($pig->status == 0) background-color: grey; @else background-color: {{$pig->color}}; @endif ">
                                <h6>{{$pig->name}}</h6>
                            </div>
                            <div class="col s12 pt-1 pb-1">
                                <h6>€{{$pig->balance}}</h6>
                            </div>
                            <div class="col s12 pt-1 pb-1">
                                {!! $Piggy_charts['chart'.$pig->id]->render()!!}
                            </div>
                        </div>
                    @if($pig->status == 1)</a>@endif
                </div>
            </div>
            @endforeach
        @endif

        @include('includes.message')
        <div class="col s4 center-align ">
            <ul class="collapsible" style="margin-left: -12px; margin-right: 17px; display: block;">
                <li>
                    <div class="collapsible-header" style="display: block;">
                        <i class="material-icons">add_circle_outline</i>
                    </div>
                    <div class="collapsible-body">
                        <form  method="POST" action="dashboard/piggy_store">
                            @csrf
                            <div class="input-field col s12 mb-2">
                                <input id="piggy_name" type="text" data-length="16" name="piggy_name">
                                <label for="piggy_name">Name</label><br>
                            </div>
                            <div class="input-field col s12 mb-2">
                                <input id="piggy_balance" type="text" data-length="16" name="piggy_balance">
                                <label for="piggy_balance">Balance</label><br>
                            </div>
                            <div class="input-field col s12 mb-2">
                                <select name="piggy_color">
                                    <optgroup label="red">
                                        <option value="#d32f2f" name="piggy_color">red-darken-2</option>
                                        <option value="#e53935" name="piggy_color">red-darken-1</option>
                                        <option value="#f44336" name="piggy_color">red</option>
                                        <option value="#ef5350" name="piggy_color">red-lighten-1</option>
                                        <option value="#e57373" name="piggy_color">red-lighten-2</option>
                                    </optgroup>
                                    <optgroup label="green">
                                        <option value="#388e3c" name="piggy_color">green-darken-2</option>
                                        <option value="#43a047" name="piggy_color">green-darken-1</option>
                                        <option value="#4caf50" name="piggy_color">green</option>
                                        <option value="#66bb6a" name="piggy_color">green-lighten-1</option>
                                        <option value="#81c784" name="piggy_color">green-lighten-2</option>
                                    </optgroup>
                                    <optgroup label="blue">
                                        <option value="#1976d2" name="piggy_color">blue-darken-2</option>
                                        <option value="#1e88e5" name="piggy_color">blue-darken-1</option>
                                        <option value="#2196f3" name="piggy_color">blue</option>
                                        <option value="#42a5f5" name="piggy_color">blue-lighten-1</option>
                                        <option value="#64b5f6" name="piggy_color">blue-lighten-2</option>
                                    </optgroup>
                                    <optgroup label="yellow">
                                        <option value="#fbc02d" name="piggy_color">yellow-darken-2</option>
                                        <option value="#fdd835" name="piggy_color">yellow-darken-1</option>
                                        <option value="#ffeb3b" name="piggy_color">yellow</option>
                                        <option value="#ffee58" name="piggy_color">yellow-lighten-1</option>
                                        <option value="#fff176" name="piggy_color">yellow-lighten-2</option>
                                    </optgroup>
                                    <optgroup label="purple">
                                        <option value="#7b1fa2" name="piggy_color">purple-darken-2</option>
                                        <option value="#8e24aa" name="piggy_color">purple-darken-1</option>
                                        <option value="#9c27b0" name="piggy_color">purple</option>
                                        <option value="#ab47bc" name="piggy_color">purple-lighten-1</option>
                                        <option value="#ba68c8" name="piggy_color">purple-lighten-2</option>
                                    </optgroup>
                                </select>
                                <label>Color</label>
                            </div>
                            <div class="input-field col s12 mt-3">
                                <button class="btn waves-effect col s12 waves-light" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </div>

@endsection