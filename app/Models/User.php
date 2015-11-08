<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'users';
	protected $fillable = ['nom', 'prenom', 'password'];
	protected $hidden = ['password', 'remember_token'];

	public function ps()
    {
        return $this->hasOne('App\Models\UserPs', 'user_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Photo', 'user_id');
    }

    public function marques()
    {
        return $this->hasMany('App\Models\MarquePs', 'user_id');
    }

    public function disponibilites()
    {
        return $this->hasMany('App\Models\Disponibilite', 'user_id');
    }

    public function getCheckPsAttribute()
    {
        if ($this->ps) { return true; } else { return false; }
    }

    public function getCheckPsActiveAttribute()
    {
        if ($this->ps && $this->ps->active == 1) { return true; } else { return false; }
    }

    public function user_avis()
    {
        return $this->hasMany('App\Models\Avis', 'user_id');
    }

    public function ps_avis()
    {
        return $this->hasMany('App\Models\Avis', 'ps_id');
    }

}
