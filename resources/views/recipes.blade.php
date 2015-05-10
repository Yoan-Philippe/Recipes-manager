@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Recipes</div>

				<div class="panel-body">
				<?php
				if (Session::has('added'))
				echo '<p style="color:green;">' . Session::get('added') . '</p>';

				if (Session::has('deleted'))
				echo '<p style="color:red;">' . Session::get('deleted') . '</p>';
				?>
					<h2>Your recipes !</h2>
					<?php 
					foreach ($recipes as $key => $value) {
						echo '<p>' . $value->name . ' | Préparation: ' . $value->prep_time . 'min + Cuisson: ' . $value->cook_time . 'min<br /><a href="recipes/delete/' . $value->id . '">Delete</a></p>';
					} ?>	

					<h2>Add your receipe !</h2>
					<form method="post" action="{{ action('RecipesController@add') }}" accept-charset="UTF-8">
						<input type="text" name="name" placeholder="Name" />
						<input type="text" name="prep_time" placeholder="Preparation time" />
						<input type="text" name="cook_time" placeholder="Cook time" />
						<input type="submit" name="btSubmit" value="Ajouter" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
