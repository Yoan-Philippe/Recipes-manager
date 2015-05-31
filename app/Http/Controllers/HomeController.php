<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Moment;
use App\Recipe;
use App\IngredientCategory;
use App\Ingredient;
use Session;
use Auth;



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
		$authId = Auth::id();
		Session::put('idUser', $authId);

		//Associate the moment of the day depend on the current hour
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

		//Get all ingredients and save those who have quantiy zero
		$ingredients = Ingredient::with('recipes')->get();
		$arrEmptyIngredients = array();
		foreach ($ingredients as $key => $value) {
			if($value->quantity==0)
			$arrEmptyIngredients[] = $value->id;
		}

		Session::put('arrEmptyIngredients', $arrEmptyIngredients);
		//$recipedWithEmptyIngredient = Recipe::with('ingredients')->whereIn( 'ingredient_id', $arrEmptyIngredients)->get();


		//Get all recipes object with some empty ingredients
		$recipedWithEmptyIngredient = Recipe::whereHas('ingredients', function($q)
		{
		    $q->whereIn('ingredient_id', Session::get('arrEmptyIngredients'));

		})->get();

		//Get All Ids of recipes with some empty ingredients
		$arrIdsRecipesWithEmptyIngredient = array();
		foreach ($recipedWithEmptyIngredient as $key => $value) {
			$arrIdsRecipesWithEmptyIngredient[] = $value->id;
		}

		Session::put('arrIdsRecipesWithEmptyIngredient', $arrIdsRecipesWithEmptyIngredient);
		//Si la variable de session id du moment existe
		if (Session::has('momentOfDayId'))
		{
			//Get all recipes that have no ingredients with quantity zero
		    $recipes = Recipe::whereHas('moments', function($q)
		    {
		        $q->where('moment_id', '=', Session::get('momentOfDayId'))->whereNotIn('recipe_id', Session::get('arrIdsRecipesWithEmptyIngredient'))
		        ->where('user_id', '=', Session::get('idUser'));

		    })->get();

		    //Get all recipes that have no ingredients with quantity zero
		    $globalRecipes = Recipe::whereHas('moments', function($q)
		    {
		        $q->where('moment_id', '=', Session::get('momentOfDayId'))->whereNotIn('recipe_id', Session::get('arrIdsRecipesWithEmptyIngredient'))
		        ->where('user_id', '=', 0);

		    })->get();
		}
		//Sinon va chercher toutes les recettes
		else
		{
			$recipes = Recipe::all();
		}

		//Clear all session variables
		Session::flush();

		$allRecipes = Recipe::orderBy('total_time')->get();;
		//$users = User::popular()->women()->orderBy('created_at')->get();
		$allIngredients = Ingredient::all();
		$ingredientCategories = IngredientCategory::all();

		return view('home')->with('momentOfDay',$momentOfDay)->with('recipes',$recipes)
			->with('allIngredients',$allIngredients)->with('ingredientCategories',$ingredientCategories)
			->with('allRecipes',$allRecipes)->with('globalRecipes',$globalRecipes);
	}

	public function reloadRecipes(){

		$dateNow = Carbon::now('America/Montreal');
		$dt = Carbon::parse($dateNow);
		$currentHour = $dt->hour;

		$moments = Moment::all();
		$momentOfDay = '';
		$momentOfDayId = 0;
		$authId = Auth::id();

		//Associate the moment of the day depend on the current hour
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
		//$recipesWithAllQuantity = Recipe::where('quantity','!=',0);

		//Get all ingredients and save those who have quantiy zero
		$ingredients = Ingredient::with('recipes')->get();
		$arrEmptyIngredients = array();
		foreach ($ingredients as $key => $value) {
			if($value->quantity==0)
			$arrEmptyIngredients[] = $value->id;
		}

		Session::put('arrEmptyIngredients', $arrEmptyIngredients);
		//$recipedWithEmptyIngredient = Recipe::with('ingredients')->whereIn( 'ingredient_id', $arrEmptyIngredients)->get();


		//Get all recipes object with some empty ingredients
		$recipedWithEmptyIngredient = Recipe::whereHas('ingredients', function($q)
		{
		    $q->whereIn('ingredient_id', Session::get('arrEmptyIngredients'));

		})->get();

		//Get All Ids of recipes with some empty ingredients
		$arrIdsRecipesWithEmptyIngredient = array();
		foreach ($recipedWithEmptyIngredient as $key => $value) {
			$arrIdsRecipesWithEmptyIngredient[] = $value->id;
		}

		Session::put('arrIdsRecipesWithEmptyIngredient', $arrIdsRecipesWithEmptyIngredient);
		//Si la variable de session id du moment existe
		if (Session::has('momentOfDayId'))
		{
			//Get all recipes that have no ingredients with quantity zero
		    $recipes = Recipe::whereHas('moments', function($q)
		    {
		        $q->where('moment_id', '=', Session::get('momentOfDayId'))->whereNotIn('recipe_id', Session::get('arrIdsRecipesWithEmptyIngredient'));

		    })->get();
		}
		//Sinon va chercher toutes les recettes
		else
		{
			$recipes = Recipe::all();
		}

		//Clear all session variables
		Session::flush();

		?>
		<ul class="sortable">
			<?php
			foreach ($recipes as $key => $value) { ?>
				<li><a class="ideasLink" href="/recipes/<?php echo $value->id ?>">
					<?php 
					if(file_exists(base_path(). '/public/img/recipes/recipe_' . $value->id . '.jpg'))
					{ ?>
						<div class="recipesContainer" style="background-image: url('/img/recipes/recipe_<?php echo $value->id ?>.jpg'); background-repeat: no-repeat; background-size:100%;">
						<!--<img class="ficheRecetteHome" src="/img/recipes/recipe_<?php echo $value->id; ?>.jpg" alt="recipes" />-->
					<?php }
					else{ ?>
						<div class="recipesContainer" style="background-image: url('/img/paresseu.jpg'); background-repeat: no-repeat; background-size:100%;">
					<?php } ?>
						<!--<img src="" alt="Image de recette" />-->
							<div class="titleBanner">
								<span><?php echo $value->name ?></span>
							</div>
						</div>
				</a></li>
			<?php }	?>
			</ul>

			<?php
		exit();
	}

}
