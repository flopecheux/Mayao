@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">
			@if(Session::has('ps'))
			{{ trans('global.step') }} 1 : 
			@endif
			{{ trans('global.register') }}
		</span>
        {!! Form::open(array('url' => '/register', 'method' => 'post')) !!}
	        <div class="required">{!! Form::text('prenom', old('prenom'), array('placeholder' => trans('global.name'))) !!}</div><br>
	        <div class="required">{!! Form::text('nom', old('nom'), array('placeholder' => trans('global.lastname'))) !!}</div><br>
	        <div class="required">{!! Form::text('email', old('email'), array('placeholder' => 'Email')) !!}</div><br>
	        <div class="required">{!! Form::text('birthday', old('birthday'), array('id' => 'date', 'placeholder' => trans('global.birthday'))) !!}</div><br>
	        <div class="required">{!! Form::password('password', array('placeholder' => trans('global.password'))) !!}</div><br>
	        <div class="required">{!! Form::password('password_confirmation', array('placeholder' => trans('global.password_c'))) !!}</div><br>
	        <div class="required">{!! Form::text('adresse', old('adresse'), array('placeholder' => trans('global.adress'))) !!}</div><br>
	        <div class="required">{!! Form::text('ville', old('ville'), array('placeholder' => trans('global.city'))) !!}</div><br>
	        <div class="required">{!! Form::text('codepostal', old('codepostal'), array('placeholder' => trans('global.postal'))) !!}</div><br>
	        <div class="required">{!! Form::text('tel', old('tel'), array('placeholder' => trans('global.tel'))) !!}</div><br>
	        {!! Form::radio('sexe', 'H', (old('sexe') == 'H'), ['id' => 'h']) !!}
	        <label for="h">{{ trans('global.man') }}</label>
	        {!! Form::radio('sexe', 'F', (old('sexe') == 'F'), ['id' => 'f']) !!}
           	<label for="f">{{ trans('global.woman') }}</label><br>
	        <button class="button" type="submit">{{ trans('global.validate_register') }}</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed"></div>

@endsection