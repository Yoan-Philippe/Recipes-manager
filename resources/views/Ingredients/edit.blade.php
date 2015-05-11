@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Ingredients <div id="txt"></div></div>

				<div class="panel-body">
					<h2>{{ $ingredient->name }}</h2>	

					<form method="post" action="{{ action('IngredientsController@edit') }}" accept-charset="UTF-8">
						<input type="hidden" value="<?php echo $ingredient->id; ?>" name="id" />
						<input type="text" value="<?php echo $ingredient->name; ?>" name="ingredient" placeholder="Name" />
						<input type="text" value="<?php echo $ingredient->quantity; ?>" name="quantity" placeholder="Quantity" />
						<select name="ingredientCategory" id="ingredientCategory">
						<?php 
							$catId = $ingredient->ingredient_category_id;
							foreach ($ingredientCategories as $key => $value) {
									if($value->id==$catId)
									$selected = 'selected="selected"';
									else
									$selected = '';

									echo '<option ' . $selected . ' value="' . $value->id . '">' . $value->name . '</option>';
							}
						?>
						</select>
						<hr/>
						<h3>Recettes</h3>
						<?php
						$cpt = 0;
							foreach ($recipes as $value) { ?>
								<p><label for="recipe_<?php echo $cpt; ?>"><?php echo $value->name; ?></label>
								<?php 
								if(in_array($value->id, $relatedIds))
								$checked='checked=checked';
								else
								$checked = '';
								?>
								<input type="checkbox" {{ $checked }} value="<?php echo $value->id; ?>" name="recipe_<?php echo $cpt; ?>" id="recipe_<?php echo $cpt; ?>" /></p>
							<?php 
							$cpt++; } ?>
						<input type="submit" name="btSubmit" value="Save" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
