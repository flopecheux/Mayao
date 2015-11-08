<div class="center">PLANNING</div>
<div class="border" style="margin-bottom:15px;"></div>

<div class="ctn">
@if($commandes->count() > 0)
    @foreach($commandes as $commande)
    <?php $horaires = explode(',', $commande->horaires); ?>
    <span class="tgreen"><u>{{ mb_strtoupper(Carbon::createFromFormat('Y-m-d', $commande->date)->formatLocalized('%A %d %B')) }}</u></span><br><br>
    <span class="thintext">PERSONAL SHOPPER</span> <a href="profil/{{ $commande->userps->id }}" style="color:black !important;">{{ strtoupper($commande->userps->prenom.' '.$commande->userps->nom) }}</a><br>
    <span class="thintext">HORAIRE</span> {{ $horaires[0] }}H-{{ end($horaires) + 1 }}H<br><br>
	@if($commande->date <= Carbon::now()->toDateString())
	<a href="/note/{{ $commande->id }}" class="thintext">> Laissez votre avis</a><br><br>
	@endif
    @endforeach
@else
    <span class="thintext"><center><br><br>VOUS N'AVEZ FAIT AUCUNE RÉSERVATION</center></span>
@endif
</div>

@include('pagination.default', ['paginator' => $commandes])