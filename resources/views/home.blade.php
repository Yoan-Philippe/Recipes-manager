@extends('app')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div id="txt"></div></div>

				<div class="panel-body">
					<?php
					foreach ($recipes as $key => $value) { ?>
						<a href="/recipes/{{ $value->id }}">
							<div class="recipesContainer">
								<h3>{{ $value->name }}</h3>
							</div>
						</a>
					<?php }	?>

				</div>
			</div>
		</div>
	</div>

	<div class="row" style="position: absolute;right: 0;top: 72px; width:30%;">
		<div class="col-md-10 col-md-offset-1">
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
							echo '<p>' . $value->name . ' (' . $value->quantity . ') - <a href="ingredients/delete/' . $value->id . '">Delete</a> - <a href="ingredients/edit/' . $value->id . '">Edit</a></p>';
						}
						echo '<hr />';
					} ?>
				</div>
			</div>
		</div>
	</div>


</div>
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/js/time.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>

@endsection
