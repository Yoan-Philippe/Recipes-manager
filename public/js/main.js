$(document).ready(function(){

	$('#addIngredientForm').hide();

	$('#addIngredient').on('click',function(){
		$('#addIngredientForm').slideToggle();
	});

	$('#addRecipeForm').hide();

	$('#addRecipe').on('click',function(){
		$('#addRecipeForm').slideToggle();
	});

	
});