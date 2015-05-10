@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Fiche de la recette<div style="float:right;" id="txt"></div></div>

				<div class="panel-body">
					<h2>{{ $recipe->name }}</h2>
					<?php 
						$totalTime = $recipe->prep_time + $recipe->cook_time;
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
