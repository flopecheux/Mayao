@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">
			MODIFIEZ VOTRE MOT DE PASSE
		</span>
        {!! Form::open(array('url' => '/password/reset', 'method' => 'post')) !!}
        	<input type="hidden" name="token" value="{{ $token }}">
	        <div class="required">{!! Form::text('email', old('email'), array('placeholder' => 'Email')) !!}</div><br>
	        <div class="required">{!! Form::password('password', array('placeholder' => trans('global.password'))) !!}</div><br>
	        <div class="required">{!! Form::password('password_confirmation', array('placeholder' => trans('global.password_c'))) !!}</div><br>
	        <button class="button" type="submit">VALIDER</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed"></div>

@endsection