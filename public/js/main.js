$(document).ready(function(){

	$('#addRecipe').on('click',function(){
		$('#addRecipeForm').slideToggle();
	});

	/*$('#strIngredientName').focus(function(){
		$('#strIngredientName').attr('placeholder','Nom');
		$('#addIngredientContainer').slideToggle();
	});


	$(document).mousedown(function (e)
	{
	    var container = $("#addIngredientContainer");
	    var containerExcept = $("#strIngredientName");

	    if (!container.is(e.target) // if the target of the click isn't the container...
	        && container.has(e.target).length === 0) // ... nor a descendant of the container
	    {
	    	if (!containerExcept.is(e.target) // if the target of the click isn't the container...
	    	    && containerExcept.has(e.target).length === 0) // ... nor a descendant of the container
	    	{
	        	container.hide(); 
	        }
	    }
	});*/

	/*$('#strIngredientName').blur(function(){
		$('#strIngredientName').attr('placeholder','Ajouter un ingrédient');
		$('#addIngredientContainer').slideToggle();
	});*/

	
});