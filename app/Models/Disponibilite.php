<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model {

	protected $table = 'disponibilites';

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
