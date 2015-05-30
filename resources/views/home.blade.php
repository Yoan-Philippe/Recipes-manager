@extends('app')


@section('content')
<div class="container">

	<div class="row" style="width: 26%;float: left;">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Recipes</div>

				<div class="panel-body">
				<?php
				if (Session::has('added'))
				echo '<p style="color:green;">' . Session::get('added') . '</p>';

				if (Session::has('deleted'))
				echo '<p style="color:red;">' . Session::get('deleted') . '</p>';

				if (Session::has('edited'))
				echo '<p style="color:green;">' . Session::get('edited') . '</p>';
				?>

				<form id="addRecipeForm" method="post" action="{{ action('RecipesController@add') }}" accept-charset="UTF-8">
					<input type="text" name="name" placeholder="Nom" />
					<input type="text" name="prep_time" placeholder="Temps de préparation" />
					<input type="text" name="cook_time" placeholder="Temps de cuisson" />
					<input type="submit" name="btSubmit" value="Ajouter" />
				</form>

					<?php 
					foreach ($allRecipes as $key => $value) {
						$totalTime = $value->total_time;
						if($totalTime>60)
						{
							$totalTime = round($totalTime/60,2) . 'h';
						}
						else
						$totalTime = $totalTime . 'min';
						echo '<a href="recipes/' . $value->id . '"><h3>' . $value->name . ' (' . $totalTime . ')</h3></a><a href="recipes/edit/' . $value->id . '">Edit</a> - <a href="recipes/delete/' . $value->id . '">Delete</a></p>';
						echo '<hr />';
					} ?>	
				</div>
			</div>
		</div>
	</div>

	<div class="row row-home-middle">
		<div class="col-md-10 col-md-offset-1" style="width: 100%;">
			<div class="panel panel-default">
				<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div id="txt"></div></div>

				<div class="panel-body" id="panelRecipe">

					<?php
					foreach ($recipes as $key => $value) { ?>
						<a class="ideasLink" href="/recipes/{{ $value->id }}">
							<div class="recipesContainer">
							<?php 
							if(file_exists(base_path(). '/public/img/recipes/recipe_' . $value->id . '.jpg'))
							{ ?>
								<img class="ficheRecetteHome" src="/img/recipes/recipe_<?php echo $value->id; ?>.jpg" alt="recipes" />
							<?php }
							else{ ?>
								<img class="ficheRecetteHome" src="/img/paresseu.jpg" alt="recipes" />
							<?php } ?>
								<!--<img src="" alt="Image de recette" />-->
								<div class="titleBanner">
									<span>{{ $value->name }}</span>
								</div>
							</div>
						</a>
					<?php }	?>

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
					<form id="addIngredientForm" method="post" action="{{ action('IngredientsController@add') }}" accept-charset="UTF-8">
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
							echo '<p id="quantityFor_' . $value->id . '">' . $value->name . ' (<span class="quantityAjax">' . $value->quantity . '</span>)<br><a href="ingredients/delete/' . $value->id . '">Delete</a> - <a href="ingredients/edit/' . $value->id . '">Edit</a></p>';
						}
						echo '<hr />';
					} ?>
				</div>
			</div>
		</div>
	</div>


</div>
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="{{ asset('/js/main.js') }}"></script>
<script src="{{ asset('/js/time.js') }}"></script>

@endsection
