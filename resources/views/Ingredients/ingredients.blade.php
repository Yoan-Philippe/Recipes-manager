@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Ingredients <div id="txt"></div></div>

				<div class="panel-body">
					<?php
					if (Session::has('added'))
					echo '<p style="color:green;">' . Session::get('added') . '</p>';

					if (Session::has('deleted'))
					echo '<p style="color:red;">' . Session::get('deleted') . '</p>';

					if (Session::has('edited'))
					echo '<p style="color:green;">' . Session::get('edited') . '</p>';
					?>
					<button id="addIngredient">Ajoute un ingredient !</button>
					<form id="addIngredientForm" method="post" action="{{ action('IngredientsController@add') }}" accept-charset="UTF-8">
						<input type="text" name="ingredient" placeholder="Name" />
						<input type="text" name="quantity" placeholder="Quantity" />
						<select name="ingredientCategory" id="ingredientCategory">
						<?php 
							foreach ($ingredientCategories as $key => $value) 
							{
								echo '<option value="' . $value->id . '">' . $value->name . '</option>';
							}
						?>
						</select>
						<input type="submit" name="btSubmit" value="Ajouter" />
					</form>	

					<?php
					foreach ($ingredientCategories as $value) {
						$idCat = $value->id;
						echo '<h3>' . $value->name . '</h3>';

						foreach ($ingredients as $key => $value) {
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
