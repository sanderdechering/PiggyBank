<?php

namespace App\Http\Controllers;

use Composer\DependencyResolver\Transaction;
use Illuminate\Http\Request;
use App\piggy;
use App\transfer;
use App\user;

use Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;
    private $user_id;
    public $total;
    public $i = 1;
    public $piggy_names = array();
    public $piggy_colors = array();
    public $piggy_color_accents = array();
    public $piggy_balances = array();
    public $piggy_charts = array();
    public $piggy_income;
    public $piggy_expense;
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {
        // User laden
        $this->user = user::find(Auth::id());

        // Huidige users ID ophalen
        $this->user_id = Auth::id();

        // Alle spaarvarkens ophalen
        $piggy = piggy::where('user_id', $this->user_id)->get();

        // Loop door elke spaarvarken heen.
        foreach ($piggy as $pig){

            // Alle spaarvarkens balances bij elkaar optellen voor een totaal bedrag
            $this->total = $this->total + $pig->balance;

            // Alle data van de spaarvarken in een aparte array stoppen. Deze data is nodig voor de donut chart
            array_push($this->piggy_names, $pig->name);
            array_push($this->piggy_colors, $pig->color);
            array_push($this->piggy_color_accents, $pig->color_accent);
            array_push($this->piggy_balances, $pig->balance);

            // Ophalen van alle transacties binnen de spaarvarken
            $transfers = transfer::where('piggy_id',$pig->id)->get();

            if(count($transfers) > 0){
                // Loopen door alle transacties uit de huidige spaarvarken
                foreach ($transfers as $transfer){

                    // Controleren of transactie uigave is
                    if ($transfer->type == 0){
                        // Tel alle uitgaven bij elkaar op
                        $this->piggy_expense = $this->piggy_expense + $transfer->amount;
                    // Controleren of transactie inkomsten is
                    }elseif($transfer->type == 1){
                        // Tel alle inkomsten bij elkaar op
                        $this->piggy_income = $this->piggy_income + $transfer->amount;
                    }else{
                        if ($pig->name == $transfer->receiver){
                            $this->piggy_income = $this->piggy_income + $transfer->amount;
                        }else{
                            $this->piggy_expense = $this->piggy_expense + $transfer->amount;
                        }
                    }

                }
            }
            // Staafchart voor inkomsten en uitgaven per spaarvarken. Staafdiagram wordt voor elk spaarvarken hier gemaakt.
            $this->piggy_charts["chart".$pig->id] = app()->chartjs
                ->name('barChartTest'.$pig->id)
                ->type('bar')
                ->size(['width' => 300, 'height' => 200])
                ->labels(['Expense', 'Income'])
                ->datasets([
                    [
                        "label" => "Income and Expense",
                        'backgroundColor' => ['#d32f2f', '#9ccc65'],
                        'data' => [$this->piggy_expense, $this->piggy_income]
                    ],
                ])
                ->optionsRaw([
                    'legend' => [
                        'display' => false,
                    ],'scales' => [
                        'yAxes' => [
                            [
                                'stacked' => false,
                                'ticks' => [
                                    'beginAtZero' => true
                                ]
                            ]
                        ]
                    ]
                    
                ]);
            // Reset de inkomsten en uitgaven variable voor volgende spaarvarken
            $this->piggy_income = 0;
            $this->piggy_expense = 0;
        }
        // Donutchart met daarin de balance van elke spaarvarken
        $Balance_total_chart = app()->chartjs
            ->name('lineChartTest')
            ->type('doughnut')
            ->size(['width' => 50, 'height' => 50])
            ->labels($this->piggy_names)
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => $this->piggy_colors,
                    'borderColor' => "rgba(255,255,255, 0.9)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(255,255,255, 0.9)",
                    'data' => $this->piggy_balances,
                ],
            ])
            ->optionsRaw([
                'legend' => [
                    'display' => false,
                ],
            ]);

        return view('dashboard/index')->with('piggy', $piggy)
            ->with('total', $this->total)
            ->with('Balance_total_chart', $Balance_total_chart)
            ->with('Piggy_charts', $this->piggy_charts)
            ->with('user', $this->user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $piggy_id)
    {
        $this->user_id = Auth::id();
        // Controleren of velden wel zijn ingevuld.

            $this->validate($request, [
                'receiver' => 'required_without:receiver_transfer',
                'receiver_transfer' => 'required_without:receiver',
                'amount' => 'numeric',
                'date' => 'required',
                'type' => 'required',
            ]);
        $transfer = new transfer();
        $transfer->user_id = $this->user_id;
        $transfer->piggy_id = $piggy_id;
        if($request->input('type') == 2){
            $transfer->receiver = $request->input('receiver_transfer');
        }else{
            $transfer->receiver = $request->input('receiver');
        }

        // Vanwege gebruik van int, extra check op verzonden nummers. 0 = expense, 1 = income, 2 = transfer to
        if (($request->input('type') > 2) || ($request->input('type') < 0)){
            return redirect('/dashboard/'.$piggy_id)->withErrors((array('message' => 'Cheaten is niet toegestaan')));
        }
        $transfer->type = $request->input('type');
        $transfer->amount = $request->input('amount');
        $transfer->date = $request->input('date');
        $transfer->note = $request->input('note');
        $transfer->save();


        if($request->input('type') == 2){
            $id = piggy::where('name', $request->input('receiver_transfer'))->where('user_id', $this->user_id)->get();
            $transfer_2 = new transfer();
            $transfer_2->user_id = $this->user_id;
            $transfer_2->piggy_id = $id[0]->id;
            $transfer_2->receiver = $request->input('receiver_transfer');
            $transfer_2->type = $request->input('type');
            $transfer_2->amount = $request->input('amount');
            $transfer_2->date = $request->input('date');
            $transfer_2->note = $request->input('note');
            $transfer_2->save();
        }

        $piggy = piggy::where('id',$piggy_id)->where('user_id', $this->user_id)->get();
        foreach ($piggy as $pig){
            if ($transfer->type == 0){
                piggy::where('id', $piggy_id)->where('user_id', $this->user_id)->update(['balance' => $pig->balance - $transfer->amount]);
            }elseif($transfer->type == 1){
                piggy::where('id', $piggy_id)->where('user_id', $this->user_id)->update(['balance' => $pig->balance + $transfer->amount]);
            }else{
                piggy::where('id', $piggy_id)->where('user_id', $this->user_id)->update(['balance' => $pig->balance - $transfer->amount]);
                $receiver_pig = piggy::where('name', $request->input('receiver_transfer'))->get();
                piggy::where('name', $receiver_pig[0]->name)->where('user_id', $this->user_id)->update(['balance' => $receiver_pig[0]->balance + $transfer->amount]);
            }
        }
        return redirect('/dashboard/'.$piggy_id);
    }
    public function piggy_store(Request $request)
    {
        $this->validate($request, [
            'piggy_name' => 'required',
            'piggy_balance' => 'required|numeric',
            'piggy_color' => 'required',
        ]);
        $this->user_id = Auth::id();
        $piggy = new piggy();
        $piggy->user_id = $this->user_id;
        $piggy->name = $request->input('piggy_name');
        $piggy->balance = $request->input('piggy_balance');
        $piggy->color = $request->input('piggy_color');
        $piggy->status = 1;
        $piggy->save();

        return redirect('/dashboard');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->user = user::find(Auth::id());
        $piggy = piggy::find($id);
        $this->user_id = Auth::id();
        $all_piggy_names = piggy::select('name')->where('user_id', $this->user_id)->get()->toArray();
        $array = array();

        foreach ($all_piggy_names as $piggy_name){
            array_push($array, $piggy_name['name']);
        }
        if (($key = array_search( $piggy->name, $array)) !== false) {
            unset($array[$key]);
        }

        $transfers = transfer::where('piggy_id',$id)->where('user_id', $this->user_id)->orderBy('date', 'asc')->paginate(4);
        foreach ($transfers as $transfer){
            $this->total = $this->total + $transfer->amount;
        }
        return view('dashboard/show')
                    ->with('transfers', $transfers)
                    ->with('piggy', $piggy)
                    ->with('total', $this->total)
                    ->with('all_piggy_names', $array)
                    ->with('user', $this->user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $piggy_id)
    {
        $this->user_id = Auth::id();
        $transfer = transfer::where('id', $id)->where('user_id',$this->user_id);
        $transfer->delete();
        return redirect('/dashboard/'.$piggy_id);
    }


}

