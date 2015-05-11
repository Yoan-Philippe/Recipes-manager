@extends('app')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div style="float:right;" id="txt"></div></div>

				<div class="panel-body">
					<?php
					foreach ($recipes as $key => $value) { ?>
						<a href="/recipes/{{ $value->id }}">
							<div class="recipesContainer" style="text-align:center;width: 30%;margin: 5px;padding: 5px;float: left;  border: 1px solid #ccc;border-radius: 3px;">
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
