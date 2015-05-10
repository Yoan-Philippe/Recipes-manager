@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Recipe <div style="float:right;" id="txt"></div></div>

				<div class="panel-body">
					<h2><?php echo $recipe->name; ?></h2>	

					<form method="post" action="{{ action('RecipesController@edit') }}" accept-charset="UTF-8">
						<input type="hidden" value="<?php echo $recipe->id; ?>" name="id" />
						<input type="text" value="<?php echo $recipe->name; ?>" name="name" placeholder="Name" /><br/>
						<input type="text" value="<?php echo $recipe->prep_time; ?>" name="prep_time" placeholder="Preparation time" /><br/>
						<input type="text" value="<?php echo $recipe->cook_time; ?>" name="cook_time" placeholder="Cook time" /><br/>
						<input type="submit" name="btSubmit" value="Save" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/time.js') }}"></script>
@endsection
