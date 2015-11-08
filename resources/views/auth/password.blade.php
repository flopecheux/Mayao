@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">
			RÉINITIALISATION DU MOT DE PASSE
		</span>
        {!! Form::open(array('url' => '/password/email', 'method' => 'post')) !!}
	        <div class="required">{!! Form::text('email', old('email'), array('placeholder' => 'Votre email')) !!}</div><br>
	        <button class="button" type="submit">VALIDER</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed"></div>

@endsection