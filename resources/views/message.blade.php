@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		
		@if($message->auteur_id == Auth::id())
		<img src="{{ $message->auteur->photo }}" style="border-radius: 200px; width: 60px; height: 60px; float:right; margin-bottom: 20px;">
		<div style="float:right; text-align:right; margin-right: 20px; margin-top:5px;">
		@else
    	<img src="{{ $message->auteur->photo }}" style="border-radius: 200px; width: 60px; height: 60px; float:left; margin-bottom: 20px;">
		<div style="float:left; text-align:left; margin-left: 20px; margin-top:5px;">
		@endif
			<div class="xltext">{{ strtoupper($message->auteur->prenom.' '.$message->auteur->nom) }}</div>
			<i>Il y a {{ Carbon::now()->diffForHumans(Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at), true) }}</i>
		</div>
		<div class="clear"></div>
		<div class="ltext thintext" style="box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.15); padding:20px; border-radius:8px; background:white; text-align: left;"> 
		{{ $message->texte }}
		</div>

		@foreach($reponses as $rep)
		<div id="{{ $rep->id }}" style="margin-top: -100px; padding-bottom: 130px;"></div>
		@if($rep->auteur_id == Auth::id())
		<img src="{{ $rep->auteur->photo }}" style="border-radius: 200px; width: 60px; height: 60px; float:right; margin-bottom: 20px;">
		<div style="float:right; text-align:right; margin-right: 20px; margin-top:5px;">
		@else
    	<img src="{{ $rep->auteur->photo }}" style="border-radius: 200px; width: 60px; height: 60px; float:left; margin-bottom: 20px;">
		<div style="float:left; text-align:left; margin-left: 20px; margin-top:5px;">
		@endif
			<div class="xltext">{{ strtoupper($rep->auteur->prenom.' '.$rep->auteur->nom) }}</div>
			<i>Il y a {{ Carbon::now()->diffForHumans(Carbon::createFromFormat('Y-m-d H:i:s', $rep->created_at), true) }}</i>
		</div>
		<div class="clear"></div>
		<div class="ltext thintext" style="box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.15); padding:20px; border-radius:8px; background:white; text-align: left;"> 
		{{ $rep->texte }}
		</div>
		@endforeach
		
		<br><br>
		{!! Form::open(array('url' => '/message/reply/'.$message->id, 'method' => 'post')) !!}
        	<span class="mtext">RÉPONDRE À CE MESSAGE</span>
	        {!! Form::textarea('message', old('message'), array('placeholder' => 'VOTRE MESSAGE', 'style' => 'border-radius:8px !important;')) !!}<br>
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