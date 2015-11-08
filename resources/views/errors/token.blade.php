@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed', 'ps' => 'true'])

<div class="content vcenter">
    <div class="hvcenter">
        <span class="xxltext">Oups... Il y'a eut une erreur !</span><br><br>
        Veuillez vérifier que votre navigateur accepte les cookies.
    </div>
</div>

@endsection