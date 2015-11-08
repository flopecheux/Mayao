@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">MODIFIER MON COMPTE</span>
        {!! Form::open(array('url' => '/update', 'method' => 'post', 'files' => true)) !!}
        	<span class="mtext">Modifier mes informations</span>
	        {!! Form::text('prenom', $user->prenom, array('placeholder' => trans('global.name'))) !!}<br>
	        {!! Form::text('nom', $user->nom, array('placeholder' => trans('global.lastname'))) !!}<br>
	        {!! Form::text('email', $user->email, array('placeholder' => 'Email')) !!}<br>
	        {!! Form::text('birthday', Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y'), array('id' => 'date', 'placeholder' => trans('global.birthday'))) !!}<br>
	        <span class="mtext">Modifier ma photo de profil</span>
			{!! Form::file('photo', old('photo')) !!}<br>
	        <span class="mtext">Modifier mon mot de passe</span>
	        {!! Form::password('password', array('placeholder' => 'Nouveau '.trans('global.password'))) !!}<br>
	        {!! Form::password('password_confirmation', array('placeholder' => trans('global.password_c'))) !!}<br>
	        <span class="mtext">Modifier mes coordonnées</span>
	        {!! Form::text('adresse', $user->adresse, array('placeholder' => trans('global.adress'))) !!}<br>
	        {!! Form::text('ville', $user->ville, array('placeholder' => trans('global.city'))) !!}<br>
	        {!! Form::text('codepostal', $user->codepostal, array('placeholder' => trans('global.postal'))) !!}<br>
	        {!! Form::text('tel', $user->tel, array('placeholder' => trans('global.tel'))) !!}<br>
	        {!! Form::radio('sexe', 'H', ($user->sexe == 'H'), ['id' => 'h']) !!}
	        <label for="h">{{ trans('global.man') }}</label>
	        {!! Form::radio('sexe', 'F', ($user->sexe == 'F'), ['id' => 'f']) !!}
           	<label for="f">{{ trans('global.woman') }}</label><br>
	        <button class="button" type="submit">VALIDER MES MODIFICATIONS</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed"></div>
@endsection