<?php namespace App\Http\Controllers;

use App\Recipe;
use Request;
use Session;

class RecipesController extends Controller {

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
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$recipes = Recipe::all();

		return view('recipes')->with('recipes',$recipes);
	}

	public function add()
	{
		if (Request::has('name'))
		{
		    $name = Request::input('name');
			$prep_time = Request::input('prep_time');
			$cook_time = Request::input('cook_time');
			
			$recipe = new Recipe;
			$recipe->name = $name;
			$recipe->prep_time = $prep_time;
			$recipe->cook_time = $cook_time;
			$recipe->save();

			Session::flash('added', 'Une nouvelle recette vient d\'être ajoutée.');
			return redirect('recipes');
		}
		else
		{
			return redirect('recipes');
		}
	}

	public function delete($id)
	{
		$recipes = Recipe::find($id);
		$recipes->delete();

		Session::flash('deleted', 'Cette recette vient d\'être supprimée.');
		return redirect('recipes');
	}

}
