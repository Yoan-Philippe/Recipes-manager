@extends('app')

@section('content')
<div class="container">
	<div class="row" style="margin-left: auto;margin-right: auto;width: 50%;">
		<div class="col-md-10 col-md-offset-1" style="width:100%;">
			<div class="panel panel-default">
				<div class="panel-heading">Fiche de la recette<div id="txt"></div></div>

				<div class="panel-body">
					<?php 
					if(file_exists(base_path(). '/public/img/recipes/recipe_' . $recipe->id . '.jpg'))
					{ ?>
						<img class="ficheRecette" src="/img/recipes/recipe_<?php echo $recipe->id; ?>.jpg" alt="recipes" />
					<?php }
					else{ ?>
						<img class="ficheRecette" src="/img/paresseu.jpg" alt="recipes" />
					<?php } ?>
					<h2>{{ $recipe->name }}</h2>
					<a href="/recipes/edit/{{ $recipe->id }}">Edit</a> | <a href="/recipes/delete/{{ $recipe->id }}">Delete</a>
					<?php 
						$totalTime = $recipe->total_time;
						if($totalTime>60)
						{
							$totalTime = round($totalTime/60,2) . 'h';
						}
						else
						$totalTime = $totalTime . 'min';

						echo '<p>Préparation: ' . $recipe->prep_time . ' minutes<br/>';
						echo 'Cuisson: ' . $recipe->cook_time . ' minutes<br/>';
						echo 'Total: ' . $totalTime . '</p>';
					?>
					<h3>Ingredients</h3>
					<hr/>
					<?php
						foreach ($recipe->ingredients as $value) { ?>
								<p>- <?php echo $value->name; ?></p>
						<?php } ?>
					<br/>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
