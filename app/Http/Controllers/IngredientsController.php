<?php namespace App\Http\Controllers;

use App\Ingredient;
use App\IngredientCategory;
use Request;
use Session;

class IngredientsController extends Controller {

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
		$ingredients = Ingredient::all();
		$ingredientCategories = IngredientCategory::all();

		return view('Ingredients.ingredients')->with('ingredients',$ingredients)->with('ingredientCategories',$ingredientCategories);
	}

	public function add()
	{
		if (Request::has('ingredient'))
		{
		    $name = Request::input('ingredient');
			$quantity = Request::input('quantity');
			$catId = Request::input('ingredientCategory');
			
			$ingredient = new Ingredient;
			$ingredient->name = $name;
			$ingredient->quantity = $quantity;
			$ingredient->ingredient_category_id = $catId;
			$ingredient->save();

			Session::flash('added', 'Un nouvel ingrédient vient d\'être ajouté.');
			return redirect('ingredients');
		}
		else
		{
			return redirect('ingredients');
		}
	}

	public function showEdit($id)
	{
		$ingredient = Ingredient::find($id);
		$ingredientCategories = IngredientCategory::all();

		return view('Ingredients.edit')->with('ingredient',$ingredient)->with('ingredientCategories',$ingredientCategories);
	}

	public function edit()
	{
		if (Request::has('id'))
		{
			$id = Request::input('id');
			$ingredient = Ingredient::find($id);

		    $name = Request::input('ingredient');
		    $quantity = Request::input('quantity');
		    $catId = Request::input('ingredientCategory');

			$ingredient->name = $name;
			$ingredient->quantity = $quantity;
			$ingredient->ingredient_category_id = $catId;
			$ingredient->save();

			Session::flash('edited', 'Cet ingrédient a bien été enregistré.');
			return redirect('ingredients');
		}
		else{
			return redirect('ingredients');
		}
	    
	}

	public function delete($id)
	{
		$ingredients = Ingredient::find($id);
		$ingredients->delete();

		Session::flash('deleted', 'Cette ingrédient vient d\'être supprimé.');
		return redirect('ingredients');
	}

}
