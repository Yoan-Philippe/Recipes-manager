<html>
	<head>
		<title>Laravel</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #1a1a1a;
				display: table;
				font-weight: 100;
				font-family: 'Comic sans ms';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">

				<!--<div class="quote">{{ Inspiring::quote() }}</div>-->
				<a href="/ingredients">Ingrédients</a>

				<h1><button id="quoimange" href="#">Quoi manger ?</button></h1>
				<h2 id="mange"></h2>

				<div id="results"></div>
			</div>
		</div>
		<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
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
	</body>
</html>
