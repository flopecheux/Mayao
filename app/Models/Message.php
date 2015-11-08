<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	protected $table = 'messages';

	public function auteur()
    {
        return $this->belongsTo('App\Models\User', 'auteur_id');
    }

	public function destinataire()
    {
        return $this->belongsTo('App\Models\User', 'destinataire_id');
    }

}