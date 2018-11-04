@extends('layout.app')

@section('content')
    @include('includes.message')
    <div class="row ">
        <div class="col s10 offset-s1 card">
            <div class="row ">
                @if($user->admin->type == 1)
                    <a href="/dashboard">
                        <div class="col s3 center-align  lighten-1 white-text" style="background-color: {{$piggy->color}}">
                            <h6>Home</h6>
                        </div>
                    </a>
                    <a href="{{route('settings')}}">
                        <div class="col s3 center-align  white-text" style="background-color: {{$piggy->color}}">
                            <h6>Settings</h6>
                        </div>
                    </a>
                    <a href="{{route('adminsettings')}}">
                        <div class="col s3 center-align  white-text" style="background-color: {{$piggy->color}}">
                            <h6>admin settings</h6>
                        </div>
                    </a>
                    <a href="{{route('logout')}}">
                        <div class="col s3 center-align  white-text" style="background-color: {{$piggy->color}}">
                            <h6>Logout</h6>
                        </div>
                    </a>
                @else
                    <a href="/dashboard">
                        <div class="col s4 center-align white-text" style="background-color: {{$piggy->color}}">
                            <h6>Home</h6>
                        </div>
                    </a>
                    <a href="{{route('settings')}}">
                        <div class="col s4 center-align  white-text" style="background-color: {{$piggy->color}}">
                            <h6>Settings</h6>
                        </div>
                    </a>
                    <a href="{{route('logout')}}">
                        <div class="col s4 center-align  white-text" style="background-color: {{$piggy->color}}">
                            <h6>Logout</h6>
                        </div>
                    </a>
                @endif
            </div>
            <div class="row section">
                <div class="col s3 center-align offset-s1">
                    <h3 class="header" style="color: {{$piggy->color}}">{{$piggy->name}}</h3>
                    @if($piggy->balance != null)
                        <h5>${{$piggy->balance}}</h5>
                    @else
                        <h5>$00.00</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s10 offset-s1 " style="color: {{$piggy->color}}">
            <h4>Transactions</h4>
        </div>
        <div class="col s10 offset-s1 center-align">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header">
                        <div class="col s3 mt-2 mb-2">
                            Receiver/Sender
                        </div>
                        <div class="col s3 mt-2 mb-2">
                            Money
                        </div>
                        <div class="col s3 mt-2 mb-2">
                            Date
                        </div>
                        <div class="col s3 mt-2 mb-2">
                            Note
                        </div>
                    </div>
                </li>
            @if(count($transfers) > 0)
                @foreach($transfers as $transfer)
                    <li>
                        <div class="collapsible-header white-text" @if($transfer->type == 0)style="background-color: #ef5350 " @elseif($transfer->type == 1) style="background-color:#9ccc65" @else style="background-color:#64b5f6" @endif>
                            <div class="col s3 pt-1 pb-1">
                                {{$transfer->receiver}}
                            </div>
                            <div class="col s3 pt-1 pb-1">
                                ${{$transfer->amount}}
                            </div>
                            <div class="col s3 pt-1 pb-1">
                                {{$transfer->date}}
                            </div>
                            <div class="col s3 truncate pt-1 pb-1">
                                <i class="material-icons">arrow_drop_down</i>
                            </div>
                        </div>

                        <div class="collapsible-body">
                            <div class="row">
                                <div class="col s7 offset-s1 left-align">
                                    {!! $transfer->note !!}
                                </div>
                                <div class="col s3 offset-s1 mb-1 mt-1">
                                    <i class="material-icons p-1">edit</i>
                                    <form method="POST" action="destroy/{{$transfer->id}}/{{$piggy->id}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class=" button-flat"><i class="material-icons p-1" style="">delete</i></button>
                                    </form>
                                </div>
                                <input type="hidden" value="{{$transfer->id}}" name="id">
                            </div>
                        </div>
                    </li>

                @endforeach
            @endif
            </ul>
            {{$transfers->links() }}
        </div>
    </div>
        <div class="row">
            <div class="col s10 offset-s1" style="color: {{$piggy->color}}">
                <h4>Add Transaction</h4>
            </div>
            <div class="col s10 offset-s1 card ">
                <form method="POST" action="store/{{$piggy->id}}" class="pt-3 pb-3">
                    @csrf
                    <div class="input-field col s3 offset-s1" id="receiver">
                        <input id="receiver" type="text" data-length="16" name="receiver">
                        <label for="receiver">Store</label><br>
                    </div>
                    @if(count($all_piggy_names) > 0)
                        <div class="input-field col s3 offset-s1" id="transfer" style="display: none">
                            <select name="receiver_transfer">
                            @foreach($all_piggy_names as $all_piggy_name)
                                <option value="{{$all_piggy_name}}">{{$all_piggy_name}}</option>
                            @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="input-field col s2">
                        <input id="amount" type="number" name="amount" step=".01">
                        <label for="amount">Money</label><br>
                    </div>
                    <div class="input-field col s2">
                        <select name="type" id="type">
                            <option value="1">Income</option>
                            <option value="0">Expense</option>
                            <option value="2">Transfer To</option>
                        </select>
                    </div>
                    <div class="input-field col s3">
                        <input type="text" class="datepicker" name="date" placeholder="yyyy-mmm-dd">
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <textarea data-length="120" name="note"></textarea>
                    </div>
                    <div class="input-field col s3 offset-s1">
                        <input type="submit" class="waves-effect waves-light btn" style="background-color: {{$piggy->color}}; color: white !important;">
                    </div>
                </form>
            </div>
        </div>
    <script>
        var type_option   = document.getElementById('type');
        type_option.addEventListener("change", function () {
            var type_value = type_option.options[type_option.selectedIndex].value;
            if (type_value == 2){
                document.getElementById('receiver').style.display = 'none';
                document.getElementById('transfer').style.display = 'block';
            }else{
                document.getElementById('receiver').style.display = 'block';
                document.getElementById('transfer').style.display = 'none';
            }
        })
    </script>
@endsection