<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model {

	protected $table = 'ingredients';

	public function ingredientCategories()
    {
        return $this->belongsTo('App\IngredientCategory');
    }

}
