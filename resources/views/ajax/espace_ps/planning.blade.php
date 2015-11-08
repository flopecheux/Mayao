<div class="center">PLANNING</div>
<div class="border" style="margin-bottom:15px;"></div>

<div class="ctn">
@if($commandes->count() > 0)
    @foreach($commandes as $commande)
    <?php $horaires = explode(',', $commande->horaires); ?>
    <span class="tgreen"><u>{{ mb_strtoupper(Carbon::createFromFormat('Y-m-d', $commande->date)->formatLocalized('%A %d %B')) }}</u></span><br><br>
    <span class="thintext">CLIENT</span> {{ mb_strtoupper($commande->user->prenom.' '.$commande->user->nom) }}<br>
    <span class="thintext">HORAIRE</span> {{ $horaires[0] }}H-{{ end($horaires) + 1 }}H<br><br>
    @endforeach
@else
    <span class="thintext"><center><br><br>VOUS N'AVEZ AUCUNE RÉSERVATION</center></span>
@endif
</div>

@include('pagination.default', ['paginator' => $commandes])