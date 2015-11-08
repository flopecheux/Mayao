<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarquePs extends Model {

	protected $table = 'marques_ps';
	public $timestamps = false;

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

	public function marque()
    {
        return $this->belongsTo('App\Models\Marque', 'marque_id');
    }

}
