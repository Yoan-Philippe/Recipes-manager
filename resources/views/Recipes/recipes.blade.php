@extends('app')

@section('content')
<div class="container">
	<div class="row row-recipes">
		<div class="col-md-10 col-md-offset-1" style="width: 100%;">
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
				{!! Form::open(
				    array(
				        'action' => 'RecipesController@add', 
				        'files' => true,
				        'id'=>'addRecipeForm')) !!}
					<p>
				    	{!! Form::label('Image de la recette') !!}
				    	{!! Form::file('image') !!}
					</p>
				<!--<form id="addRecipeForm" method="post" action="{{ action('RecipesController@add') }}" accept-charset="UTF-8">-->
					<input type="text" name="name" placeholder="Nom" />
					<input type="text" name="prep_time" placeholder="Temps de préparation" />
					<input type="text" name="cook_time" placeholder="Temps de cuisson" />
					<input type="submit" name="btSubmit" value="Ajouter" />
				</form>

				<ul class="sortable">
				<?php
				foreach ($recipes as $key => $value) { ?>
					<li class="recipesLi">
						<a class="ideasLink" href="/recipes/{{ $value->id }}">
						<?php 
						if(file_exists(base_path(). '/public/img/recipes/recipe_' . $value->id . '.jpg'))
						{ ?>
							<div class="recipesContainer" style="background-image: url('/img/recipes/recipe_{{ $value->id }}.jpg'); background-repeat: no-repeat; background-size:100%;">
							<!--<img class="ficheRecetteHome" src="/img/recipes/recipe_<?php echo $value->id; ?>.jpg" alt="recipes" />-->
						<?php }
						else{ ?>
							<div class="recipesContainer" style="background-image: url('/img/paresseu.jpg'); background-repeat: no-repeat; background-size:100%;">
						<?php } ?>
							<!--<img src="" alt="Image de recette" />-->
								<div class="titleBanner">
									<span>{{ $value->name }}</span>
								</div>
							</div>
						</a>
					</li>
				<?php }	?>
				</ul>

				<!--<a href="recipes/edit/{{ $value->id }}">Edit</a> - <a href="recipes/delete/{{ $value->id }}">Delete</a>-->

					<?php 
					/*foreach ($recipes as $key => $value) {
						$totalTime = $value->total_time;
						if($totalTime>60)
						{
							$totalTime = round($totalTime/60,2) . 'h';
						}
						else
						$totalTime = $totalTime . 'min';
						echo '<a href="recipes/' . $value->id . '"><h3>' . $value->name . ' (' . $totalTime . ')</h3></a><a href="recipes/edit/' . $value->id . '">Edit</a> - <a href="recipes/delete/' . $value->id . '">Delete</a></p>';
					}*/ ?>	
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
