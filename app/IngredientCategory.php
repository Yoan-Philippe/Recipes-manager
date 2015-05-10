<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model {

	protected $table = 'ingredient_categories';

	public function ingredients()
    {
        return $this->hasMany('App\Ingredient');
    }

}
