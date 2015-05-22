@extends('app')

@section('content')
<div class="container">
	<div class="row" style="margin-left: auto;margin-right: auto;width: 50%;">
		<div class="col-md-10 col-md-offset-1" style="width:100%;">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Recipe <div id="txt"></div></div>

				<div class="panel-body">
					<h2><?php echo $recipe->name; ?></h2>	

					<?php 
					if(file_exists(base_path(). '/public/img/recipes/recipe_' . $recipe->id . '.jpg'))
					{ ?>
						<img class="ficheRecette" src="/img/recipes/recipe_<?php echo $recipe->id; ?>.jpg" alt="recipes" />
					<?php }
					else{ ?>
						<img class="ficheRecette" src="/img/paresseu.jpg" alt="recipes" />
					<?php } ?>
					

					{!! Form::open(
					    array(
					        'action' => 'RecipesController@edit', 
					        'files' => true)) !!}

					
						<p>
					    	{!! Form::label('Image de la recette') !!}
					    	{!! Form::file('image') !!}
						</p>

						<input type="hidden" value="<?php echo $recipe->id; ?>" name="id" />
						<input type="text" value="<?php echo $recipe->name; ?>" name="name" placeholder="Name" /><br/>
						<input type="text" value="<?php echo $recipe->prep_time; ?>" name="prep_time" placeholder="Preparation time" /><br/>
						<input type="text" value="<?php echo $recipe->cook_time; ?>" name="cook_time" placeholder="Cook time" /><br/>
						<h3>Ingredients</h3>
						<hr/>
						<?php
							foreach ($recipe->ingredients as $value) { ?>
									<p>- <?php echo $value->name; ?></p>
							<?php } ?>
						<br/>
						<h3>Moment de la journée</h3>
						<?php 
							$cpt=0;
							foreach ($moments as $key => $value) { ?>
								<p><label for="moment_<?php echo $cpt; ?>"><?php echo $value->name; ?></label>
								<?php 
								if(in_array($value->id, $relatedIds))
								$checked='checked=checked';
								else
								$checked = '';
								?>
								<input type="checkbox" {{ $checked }} value="<?php echo $value->id; ?>" name="moment_<?php echo $cpt; ?>" id="moment_<?php echo $cpt; ?>" /></p>
							<?php $cpt++; }
						?>
						<input type="submit" name="btSubmit" value="Save" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
