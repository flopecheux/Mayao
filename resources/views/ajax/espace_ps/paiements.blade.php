<div class="center">PAIEMENTS</div>

<table class="table" style="width:100%; margin-top:10px; margin-bottom:20px;">
<tr class="tgreen">
	<th>DATE</th>
	<th>CLIENT</th>
	<th>TOTAL</th>
	<th>INFOS</th>
</tr>
@if($paiements->count() > 0)
@foreach($paiements as $paiement)
<tr>
	<td>{{ Carbon::createFromFormat('Y-m-d', $paiement->date)->format('d/m/Y') }}</td>
	<td>{{ $paiement->user->prenom }} {{ $paiement->user->nom }}</td>
	<td>{{ number_format($paiement->tarif - $paiement->tarif*0.1, 2) }}€</td>
	<td>
	@if($paiement->statut == 1)
	En attente
	@elseif($paiement->statut == 3)
	Payé
	@else
	Annulé
	@endif
	</td>
</tr>
@endforeach
@else
<tr>
	<td colspan="4">Aucun paiement</td>
</tr>
@endif
</table>
@include('pagination.default', ['paginator' => $paiements])<br>

<a href="/update/bank" class="button flat text"><small>MODIFIER MES INFORMATIONS BANCAIRES</small></a>

