<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Models\User;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function show(){
        $search = Search::join('users', 'searches.user_id','users.id')
        ->select('searches.keyword','searches.created_at','users.name as uname')
        ->latest()->get();
        $k_arr = array();
        $users = User::all();

        foreach($search as $s){
            if(!array_key_exists($s->keyword,$k_arr)){
                $k_arr[$s->keyword] = 1;
            }
            else{
                $k_arr[$s->keyword] += 1;
            }
        }

        return view("logs",[
            'searches'=>$search,
            'keywords' => $k_arr,
            'users' => $users
        ]);
    }

    public function store(Request $request){
        $user = Auth::user()->id;

        $request->validate([
            "keyword" => "required"
        ]);

        $str = str_replace(" ","_",$request->keyword);
        $search_entry = new Search;
        $search_entry->user_id = $user;
        $search_entry->keyword = strtolower($str);
        $search_entry->save();

        Session::flash("success","You searched for a keyword");
        return redirect('/dashboard');
    }

    public function search_by_type(Request $request,$name){
        
        if($request->type == 'name'){
            $search = Search::join('users', 'searches.user_id','users.id')
            ->select('searches.keyword','searches.created_at','users.name as uname')
            ->where('users.name',$name)
            ->latest()->get();
        }

        if($request->type == "keyword"){
            $search = Search::join('users', 'searches.user_id','users.id')
            ->select('searches.keyword','searches.created_at','users.name as uname')
            ->where('searches.keyword',$name)
            ->latest()->get();       
    }

    if($request->type == "time"){
        if($name == "yes"){
            $yesterday = Carbon::yesterday()->toDateString();
            $search = DB::table('searches')
            ->join('users', 'users.id', '=', 'searches.user_id')
            ->select('users.name as uname', 'searches.keyword', 'searches.created_at')
            ->whereDate('searches.created_at',$yesterday)
            ->latest()
            ->get();
        }

        if($name == "lweek"){
            $start = Carbon::now()->subWeek()->startOfWeek();
            $end = Carbon::now()->subWeek()->endOfWeek();
            
            $search = DB::table('searches')
            ->join('users', 'users.id', '=', 'searches.user_id')
            ->select('users.name as uname', 'searches.keyword', 'searches.created_at')
            ->whereBetween('searches.created_at',[$start,$end])
            ->latest()
            ->get();
        }

        if($name == "lmonth"){
            $month = Carbon::now()->subMonth()->format('m');
            $search = DB::table('searches')
            ->join('users', 'users.id', '=', 'searches.user_id')
            ->select('users.name as uname', 'searches.keyword', 'searches.created_at')
            ->whereMonth('searches.created_at',$month)
            ->latest()
            ->get();
        }
    }


    if($request->name == "range"){
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $search = DB::table('searches')
            ->join('users', 'users.id', '=', 'searches.user_id')
            ->select('users.name as uname', 'searches.keyword', 'searches.created_at')
            ->whereBetween('searches.created_at',[$start,$end])
            ->latest()
            ->get();
    }


    return response()->json($search);

}

}
