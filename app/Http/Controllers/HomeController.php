<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Moment;
use App\Recipe;
use App\Ingredient;
use Session;



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
		$momentOfDayId = 0;

		foreach ($moments as $value) {
			$id = $value->id;
			$name = $value->name;
			$min = $value->min;
			$max = $value->max;

			if($currentHour>=$min&&$currentHour<=$max)
			{
				$momentOfDay = $name;
				$momentOfDayId = $id;	

				Session::put('momentOfDayId', $momentOfDayId);
			}
		}

		//Si la variable de session id du moment existe
		if (Session::has('momentOfDayId'))
		{
		    $recipes = Recipe::whereHas('moments', function($q)
		    {
		        $q->where('moment_id', '=', Session::get('momentOfDayId'));

		    })->get();

		    $arrIngredients = array();
		    //foreach ($recipes as $key => $value) {
		    	$ingredients = Ingredient::whereHas('recipes', function($q)
		    	{
		    	    $q->where('recipe_id', '=', 6);

		    	})->get();

		    	$nbrIngredients = Ingredient::whereHas('recipes', function($q)
		    	{
		    	    $q->where('recipe_id', '=', 6);

		    	})->count();

		    	foreach ($ingredients as $key => $value) {
		    		if($value->quantity!=0)
		    		$arrIngredients[] = $value->name . $value->quantity;
		    	}
		    	//if(count($arrIngredients)<$nbrIngredients)
		    //}
		}
		//Sinon va chercher toutes les recettes
		else
		{
			$recipes = Recipe::all();
		}

		return view('home')->with('momentOfDay',$momentOfDay)->with('recipes',$recipes);
	}

}
