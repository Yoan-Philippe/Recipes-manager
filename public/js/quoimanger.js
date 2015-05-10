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