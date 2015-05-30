var canEdit = true;
$(document).ready(function(){

	$('#addRecipe').on('click',function(){
		$('#addRecipeForm').slideToggle();
	});

	$('.ideasLink').on('mouseenter',function(){
		$(this).find('.titleBanner').animate({'bottom':'0'});

		
	});

	$('.ideasLink').on('mouseleave',function(){
		$(this).find('.titleBanner').animate({'bottom':'-45px'},'fast');
	});

	$('#sortable').sortable();
	$('#sortable').disableSelection();

	
	$(".quantityAjax").click(function(){

		if(canEdit==true)
		{
			idIngredient = $(this).parent().attr('id');
			valueQuantity = $(this).text();

		        $.post("/ingredients/editQuantity/" + valueQuantity,
		        {
		          value: valueQuantity
		        },
		        function(data,status){
		            $('#'+idIngredient).find('span').html(data);
		            canEdit = false;

		        });
		}
	});
	
	$('#addIngredientContainer').hide();
	$('#strIngredientName').focus(function(){
		$('#strIngredientName').attr('placeholder','Nom');
		$('#addIngredientContainer').slideDown();
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
	        	$('#strIngredientName').attr('placeholder','Ajouter un ingrédient');
	        }
	    }
	});

	/*$('#strIngredientName').blur(function(){
		$('#strIngredientName').attr('placeholder','Ajouter un ingrédient');
		$('#addIngredientContainer').slideToggle();
	});*/

	
});

$( document ).ajaxSuccess(function( event, xhr, settings ) {

	$('.inputQuantity').focus();
	$('.inputQuantity').on('blur',function(){

		nowQuantity = $(this).val();
		idIngredient = $(this).parent().parent().attr('id');

		$.post("/ingredients/saveQuantity/" + nowQuantity + '/' + idIngredient,
		{
		  value: nowQuantity,
		  id: idIngredient
		},
		function(data,status){
		    $('#'+idIngredient).find('span').html(data);
		    canEdit = true;

		    $.post("/home/reloadRecipes/",
		    {},
		    function(data,status){
		        $('#panelRecipe').html(data);
		    });
		});
	});
});