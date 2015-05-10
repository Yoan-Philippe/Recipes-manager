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
<script type="text/javascript">
$( document ).ready(function() {

	var arrRepas = ['Grilled cheese','Pizza','Macaroni','Toast beurre de pin','Pâté chinois'];
	var number = Math.floor(Math.random() * 5);
	localStorage.setItem("number", number);

	 var uniqueRandoms = [];
		var numRandoms = 5;

	//$('#mange').hide();
	$('#quoimange').on('click',function(){
		currentNbr = localStorage.getItem("number");
		$('#mange').text(arrRepas[number]);
		//$('#mange').slideToggle();
		$('#quoimange').text('Pas satisfait ?');

		var i = 0;
	    var rand = makeUniqueRandom();
	    $('#mange').text(arrRepas[rand]);
	});

	
	function makeUniqueRandom() {
	    // refill the array if needed
	    if (!uniqueRandoms.length) {
	        for (var i = 0; i < numRandoms; i++) {
	            uniqueRandoms.push(i);
	        }
	    }
	    var index = Math.floor(Math.random() * uniqueRandoms.length);
	    var val = uniqueRandoms[index];

	    // now remove that value from the array
	    uniqueRandoms.splice(index, 1);
	    return val;
	}
});
</script>

@endsection
