@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">QU'AVEZ VOUS PENSÉ DE VOTRE PRESTATION<br>AVEC {{ strtoupper($commande->userps->prenom.' '.$commande->userps->nom) }} ?</span>
		<br><br>
		{!! Form::open(array('url' => '/note/'.$commande->id, 'method' => 'post')) !!}
        	<div class="note">DONNEZ UNE NOTE :<br></div><br>
        	<input type="hidden" id="note" name="note">
	        {!! Form::textarea('commentaire', old('message'), array('placeholder' => 'VOTRE AVIS', 'style' => 'border-radius:8px !important;')) !!}<br>
			<button type="submit" class="button">ENVOYER</button>
	    {!! Form::close() !!}
	    <br>
    </div>
</div>

<div class="navbottom fixed">
    <a href="/espace">RETOURNER À MON ESPACE</a>
    <img src="./img/Forme-2.png">
</div>
@endsection

@section('customjs')
$('.note').raty({
  targetScore: '#note'
});
@endsection