@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="content vcenter">
    <div class="hvcenter">
        @if($payment->Status == 'SUCCEEDED')
        <span class="xxltext">MERCI !</span><br><br>
        Un email récapitulatif de votre commande vient de vous être envoyé.<br><br>
        À très vite,<br>
        L'équipe MAYAO
        @else
        <span class="xxltext">PAIEMENT ANNULÉ !</span><br><br>
        La commande n'a pas été validé.
        @endif
    </div>
</div>

@endsection