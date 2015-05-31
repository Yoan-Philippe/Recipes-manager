<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model {

	protected $table = 'recipes';

	public function users()
    {
        return $this->belongsTo('App\User');
    }

	public function ingredients()
	{
		return $this->belongsToMany('App\Ingredient','ingredient_recipe','recipe_id','ingredient_id');
	}

	public function moments()
	{
		return $this->belongsToMany('App\Moment','moment_recipe','recipe_id','moment_id');
	}

}
