@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper hvcenter register">
		<span class="xltext">QUE SOUHAITEZ-VOUS FAIRE ?</span><br>

		<a href="/register/0" class="button">JE SOUHAITE RÉSERVER DES SERVICES DE PERSONAL SHOPPING</a><br><br><br>
		<a href="/register/1" class="button">JE SOUHAITE PROPOSER MES SERVICES DE PERSONAL SHOPPING</a>
        
    </div>
</div>

<div class="navbottom fixed"></div>

@endsection