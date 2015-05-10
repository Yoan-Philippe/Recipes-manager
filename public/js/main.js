$(document).ready(function(){

	$('#addIngredientForm').hide();

	$('#addIngredient').on('click',function(){
		$('#addIngredientForm').slideToggle();
	});
});