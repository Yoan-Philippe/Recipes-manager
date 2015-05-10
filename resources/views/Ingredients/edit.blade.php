@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Ingredients <div style="float:right;" id="txt"></div></div>

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
						<input type="submit" name="btSubmit" value="Save" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
