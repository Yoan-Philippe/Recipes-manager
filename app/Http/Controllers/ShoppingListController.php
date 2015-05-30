<?php namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use App\IngredientCategory;
use Request;
use Session;

class ShoppingListController extends Controller {

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
		$ingredients = Ingredient::all()->where('quantity','0');
		$allIngredients = Ingredient::where('quantity','!=','0')->get();
		$ingredientCategories = IngredientCategory::all();

		return view('Shopping_list.shopping_list')->with('ingredients',$ingredients)->with('ingredientCategories',$ingredientCategories)
		->with('allIngredients',$allIngredients);
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
			return redirect('/');
		}
		else
		{
			return redirect('/');
		}
	}

	public function showEdit($id)
	{
		$ingredient = Ingredient::find($id);

		if($ingredient!=null)
		{
			$ingredientCategories = IngredientCategory::all();
			$recipes = Recipe::all();

			$relatedIds = $ingredient->recipes()->getRelatedIds();

			return view('Ingredients.edit')->with('ingredient',$ingredient)->with('ingredientCategories',$ingredientCategories)
				->with('recipes',$recipes)->with('relatedIds',$relatedIds);
		}
		else
		{
			return redirect('got_prob?');
		}

		
	}

	public function edit()
	{
		if (Request::has('id'))
		{
			//Get value that are checked
			$nbrRecipes = Recipe::count();
			$arrIdChecked = array();
			for($cpt=0; $cpt<$nbrRecipes; $cpt++){
				if(Request::input('recipe_' . $cpt)!='')
				$arrIdChecked[] = Request::input('recipe_' . $cpt);
			}


			$id = Request::input('id');
			$ingredient = Ingredient::find($id);

		    $name = Request::input('ingredient');
		    $quantity = Request::input('quantity');
		    $catId = Request::input('ingredientCategory');

		    $ingredient->recipes()->sync($arrIdChecked);

			$ingredient->name = $name;
			$ingredient->quantity = $quantity;
			$ingredient->ingredient_category_id = $catId;
			$ingredient->save();

			Session::flash('edited', 'Cet ingrédient a bien été enregistré.');
			return redirect('/');
		}
		else{
			return redirect('/');
		}   
	}

	public function editQuantity($value)
	{
		//$ingredient = Ingredient::find($id);

		return '<input name="quantity" style="width:90px" value="' . $value . '" class="inputQuantity" autofocus/>';
		exit();
	}

	public function saveQuantity($value,$id)
	{
		$idIngredient = str_replace('quantityFor_', '', $id);
		$ingredient = Ingredient::find($idIngredient);
		$ingredient->quantity = $value;
		$ingredient->save();
		
		return $value;
		exit();
	}

	

	public function delete($id)
	{
		$ingredients = Ingredient::find($id);
		$ingredients->delete();

		Session::flash('deleted', 'Cette ingrédient vient d\'être supprimé.');
		return redirect('ingredients');
	}

}
