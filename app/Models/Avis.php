<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model {

	protected $table = 'avis';

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

	public function userps()
    {
        return $this->belongsTo('App\Models\User', 'ps_id');
    }

	public function commande()
    {
        return $this->belongsTo('App\Models\Commande', 'commande_id');
    }

}