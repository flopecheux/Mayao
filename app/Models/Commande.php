<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model {

	protected $table = 'commandes';

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

	public function userps()
    {
        return $this->belongsTo('App\Models\User', 'ps_id');
    }

	public function avis()
    {
        return $this->hasOne('App\Models\Avis', 'commande_id');
    }

}