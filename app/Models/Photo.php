<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

	protected $table = 'photos_ps';

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
