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
	public function index($test = null)
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

		$ingredientCategories = IngredientCategory::all();
		$allIngredients = Ingredient::all();
		?>

		<div class="row row-home-middle">
			<div class="col-md-10 col-md-offset-1" style="width: 100%;">
				<div class="panel panel-default">
					<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div id="txt"></div></div>

					<div class="panel-body">

					<h3>Vos recettes</h3>
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
					</div>

					<div class="panel-body">
						<h3>Recettes générales</h3>
						<?php 
						if(count($globalRecipes)==0)
							echo '<p>Aucune recette de disponible</p>';
						else{ ?>
							<ul class="sortable">
								<?php
								foreach ($globalRecipes as $key => $value) { ?>
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
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row" style="float: right;width: 28%;">
			<div class="col-md-10 col-md-offset-1" style="width:100%;">
				<div class="panel panel-default">
					<div class="panel-heading">Mes ingrédients</div>

					<div class="panel-body">
						<?php
						if (Session::has('added'))
						echo '<p style="color:green;">' . Session::get('added') . '</p>';

						if (Session::has('deleted'))
						echo '<p style="color:red;">' . Session::get('deleted') . '</p>';

						if (Session::has('edited'))
						echo '<p style="color:green;">' . Session::get('edited') . '</p>';
						?>
						<form id="addIngredientForm" method="post" action="<?php echo action('IngredientsController@add') ?>" accept-charset="UTF-8">
							<input type="text" name="ingredient" style="border-radius: 4px;width: 48%;border: 1px solid #ccc;height: 38px;padding-left: 10px;" id="strIngredientName" placeholder="Ajouter un ingrédient" />
							<div id="addIngredientContainer" style="float:right">
								<input type="text" style="width: 80px;height: 38px;padding-left: 12px;border: 1px solid #ccc;border-radius: 4px;" name="quantity" placeholder="Quantity" />
								<select name="ingredientCategory" id="ingredientCategory" style="height: 38px;border: 1px solid #ccc;border-radius: 4px;">
								<?php 
									foreach ($ingredientCategories as $key => $value) 
									{
										echo '<option value="' . $value->id . '">' . $value->name . '</option>';
									}
								?>
								</select>
								<input type="submit" name="btSubmit" value="Ajouter" style="height: 38px;background-color: #ddd;" />
							</div>
						</form>	

						
						<?php
						foreach ($ingredientCategories as $value) {
							$idCat = $value->id;
							echo '<h3>' . $value->name . '</h3>';

							foreach ($allIngredients as $key => $value) {
								if($value->ingredient_category_id==$idCat)
								echo '<p id="quantityFor_' . $value->id . '"><a href="ingredients/edit/' . $value->id . '">' . $value->name . '</a> (<span class="quantityAjax">' . $value->quantity . '</span>) - <a href="ingredients/delete/' . $value->id . '">[x]</a></p>';
							}
							echo '<hr />';
						} ?>
					</div>
				</div>
			</div>
		</div>
			<?php
		exit();
	}

}
