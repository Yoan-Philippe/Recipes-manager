<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Moment extends Model {

	protected $table = 'moments';

    public function recipes()
    {
    	return $this->belongsToMany('App\Recipe','moment_recipe','moment_id','recipe_id');
    }

}
