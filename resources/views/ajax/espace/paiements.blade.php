<div class="center">PAIEMENTS</div>

<table class="table" style="width:100%; margin-top:10px; margin-bottom:20px;">
<tr class="tgreen">
	<th>DATE</th>
	<th>PERSONAL SHOPPER</th>
	<th>TOTAL</th>
</tr>
@if($paiements->count() > 0)
@foreach($paiements as $paiement)
<tr>
	<td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $paiement->created_at)->format('d/m/Y') }}</td>
	<td><a href="profil/{{ $paiement->userps->id }}">{{ $paiement->userps->prenom }} {{ $paiement->userps->nom }}</a></td>
	<td>{{ number_format($paiement->tarif, 2) }}€</td>
</tr>
@endforeach
@else
<tr>
	<td colspan="4">Aucun paiement</td>
</tr>
@endif
</table>
@include('pagination.default', ['paginator' => $paiements])
<br>