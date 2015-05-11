@extends('app')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div id="txt"></div></div>

				<div class="panel-body">
					<?php
					foreach ($recipes as $key => $value) { ?>
						<a href="/recipes/{{ $value->id }}">
							<div class="recipesContainer">
								<h3>{{ $value->name }}</h3>
							</div>
						</a>
					<?php }	?>

				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/js/time.js') }}"></script>

@endsection
