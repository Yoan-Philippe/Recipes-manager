@extends('app')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Pas d'idée pour le <b><?php echo $momentOfDay; ?></b> ? <div style="float:right;" id="txt"></div></div>


				<div class="panel-body">
					<h1><button id="quoimange" href="#">Quoi manger ?</button></h1>
					<h2 id="mange"></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/js/time.js') }}"></script>
<script src="{{ asset('/js/quoimanger.js') }}"></script>

@endsection
