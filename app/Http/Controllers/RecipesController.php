<?php namespace App\Http\Controllers;

use App\Recipe;
use App\Ingredient;
use App\Moment;
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

		return view('Recipes.recipes')->with('recipes',$recipes);
	}

	public function view($id)
	{
		$recipe = Recipe::find($id);
		return view('Recipes.view')->with('recipe',$recipe);
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

	public function showEdit($id)
	{
		$recipe = Recipe::find($id);
		$ingredients = Ingredient::all();
		$moments = Moment::all();

		$relatedIds = $recipe->moments()->getRelatedIds();

		return view('Recipes.edit')->with('recipe',$recipe)->with('ingredients',$ingredients)->with('moments',$moments)
			->with('relatedIds',$relatedIds);
	}

	public function edit()
	{
		if (Request::has('id'))
		{
			//Get value that are checked
			$nbrMoments = Moment::count();
			$arrIdChecked = array();
			for($cpt=0; $cpt<$nbrMoments; $cpt++){
				if(Request::input('moment_' . $cpt)!='')
				$arrIdChecked[] = Request::input('moment_' . $cpt);
			}

			$id = Request::input('id');
			$recipe = Recipe::find($id);

		    $name = Request::input('name');
			$prep_time = Request::input('prep_time');
			$cook_time = Request::input('cook_time');

			$recipe->moments()->sync($arrIdChecked);

			$recipe->name = $name;
			$recipe->prep_time = $prep_time;
			$recipe->cook_time = $cook_time;
			$recipe->save();

			Session::flash('edited', 'Cette recette a bien été enregistrée.');
			return redirect('recipes');
		}
		else{
			return redirect('recipes');
		}
	    
	}

	public function delete($id)
	{
		$recipe = Recipe::find($id);
		$recipe->delete();

		Session::flash('deleted', 'Cette recette vient d\'être supprimée.');
		return redirect('recipes');
	}

}
