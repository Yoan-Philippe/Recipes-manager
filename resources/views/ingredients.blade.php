@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Ingredients</div>

				<div class="panel-body">
				<?php
				if (Session::has('added'))
				echo '<p style="color:green;">' . Session::get('added') . '</p>';

				if (Session::has('deleted'))
				echo '<p style="color:red;">' . Session::get('deleted') . '</p>';
				?>
					<h2>Your ingredient !</h2>
					<?php 
					foreach ($ingredients as $key => $value) {
						echo '<p>' . $value->name . ' (' . $value->quantity . ')<br /><a href="ingredients/delete/' . $value->id . '">Delete</a></p>';
					} ?>	

					<h2>Add your ingredient !</h2>
					<form method="post" action="{{ action('IngredientsController@add') }}" accept-charset="UTF-8">
						<input type="text" name="ingredient" placeholder="Name" />
						<input type="text" name="quantity" placeholder="Quantity" />
						<input type="submit" name="btSubmit" value="Ajouter" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
