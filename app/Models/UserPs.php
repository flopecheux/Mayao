<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPs extends Model {

	protected $table = 'users_ps';

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getListIconesAttribute()
    {
    	$icones = explode(',', $this->icones);
    	return $icones;
    }

    public function getListVillesAttribute()
    {
        $villes = explode(',', $this->villes);
        return $villes;
    }

}
