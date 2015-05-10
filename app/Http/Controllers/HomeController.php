<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Moment;



class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		//$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$dateNow = Carbon::now('America/Montreal');
		$dt = Carbon::parse($dateNow);
		$currentHour = $dt->hour; 

		$moments = Moment::all();
		$momentOfDay = '';

		foreach ($moments as $value) {
			$name = $value->name;
			$min = $value->min;
			$max = $value->max;

			if($currentHour>$min&&$currentHour<$max)
			$momentOfDay = $name;
		}
		return view('home')->with('momentOfDay',$momentOfDay);
	}

}
