@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper center register">
		<span class="xltext">MODIFIER MES INFORMATIONS BANCAIRES</span><br>
		IBAN : {{ substr_replace($bank->Details->IBAN, 'XXXXXXXXXXXXXXXXXX', 0, 18) }}<br>
		BIC : {{ $bank->Details->BIC }}<br><br>
        {!! Form::open(array('url' => '/update/bank', 'method' => 'post')) !!}
	        {!! Form::text('iban', old('iban'), array('placeholder' => 'IBAN')) !!}<br>
	        {!! Form::text('bic', old('bic'), array('placeholder' => 'BIC')) !!}<br>
	        <button class="button" type="submit">VALIDER MES MODIFICATIONS</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed">
	<a href="/espace">RETOURNER À MON ESPACE</a>
    <img src="./img/Forme-2.png">
</div>
@endsection