@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Recipes <div id="txt"></div></div>

				<div class="panel-body">
				<?php
				if (Session::has('added'))
				echo '<p style="color:green;">' . Session::get('added') . '</p>';

				if (Session::has('deleted'))
				echo '<p style="color:red;">' . Session::get('deleted') . '</p>';

				if (Session::has('edited'))
				echo '<p style="color:green;">' . Session::get('edited') . '</p>';
				?>

				<button id="addRecipe">Ajoute une recette !</button>
				<form id="addRecipeForm" method="post" action="{{ action('RecipesController@add') }}" accept-charset="UTF-8">
					<input type="text" name="name" placeholder="Nom" />
					<input type="text" name="prep_time" placeholder="Temps de préparation" />
					<input type="text" name="cook_time" placeholder="Temps de cuisson" />
					<input type="submit" name="btSubmit" value="Ajouter" />
				</form>

					<?php 
					foreach ($recipes as $key => $value) {
						$totalTime = $value->prep_time + $value->cook_time;
						if($totalTime>60)
						{
							$totalTime = round($totalTime/60,2) . 'h';
						}
						else
						$totalTime = $totalTime . 'min';
						echo '<a href="recipes/' . $value->id . '"><h3>' . $value->name . ' (' . $totalTime . ')</h3></a><a href="recipes/edit/' . $value->id . '">Edit</a> - <a href="recipes/delete/' . $value->id . '">Delete</a></p>';
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
