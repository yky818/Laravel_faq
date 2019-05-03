<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Question;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sort = ($request->sortby)?$request->sortby:'';
        $allquestions = Question::withCount('votes');
        
        if($sort == 'newest'){
           $questions = $allquestions->orderBy('created_at', 'desc')->limit(12)->get();
        }else{
           $questions =  $allquestions->orderBy('votes_count', 'desc')->limit(12)->get();

        }
        return view('home')->with(['questions'=> $questions,'sort'=>$sort]);
    }
}
