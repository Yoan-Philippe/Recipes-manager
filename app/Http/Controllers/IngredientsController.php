<?php namespace App\Http\Controllers;

use App\Ingredient;
use Request;
use Session;

class IngredientsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ingredients = Ingredient::all();

		return view('ingredients')->with('ingredients',$ingredients);
	}

	public function add()
	{
		if (Request::has('ingredient'))
		{
		    $name = Request::input('ingredient');
			$quantity = Request::input('quantity');
			
			$ingredient = new Ingredient;
			$ingredient->name = $name;
			$ingredient->quantity = $quantity;
			$ingredient->save();

			Session::flash('added', 'Un nouvel ingrédient vient d\'être ajouté.');
			return redirect('ingredients');
		}
		else
		{
			return redirect('ingredients');
		}
	}

	public function delete($id)
	{
		$ingredients = Ingredient::find($id);
		$ingredients->delete();

		Session::flash('deleted', 'Cette ingrédient vient d\'être supprimé.');
		return redirect('ingredients');
	}

}
