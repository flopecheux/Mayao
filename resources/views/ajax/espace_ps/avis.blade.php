<div class="center">COMMENTAIRES</div>
<div class="border" style="margin-bottom:15px;"></div>

<div class="ctn">
@if($avis->count() > 0)
    @foreach($avis as $a)
    <span class="tgreen"><u>{{ mb_strtoupper($a->user->prenom.' '.$a->user->nom) }}</u></span>
    <div class="score min" data-score="{{ $a->note }}"></div><br><br>
    <span class="thintext">{{ $a->commentaire }}</span><br><br>
    @endforeach
@else
    <span class="thintext"><center><br><br>VOUS N'AVEZ AUCUN COMMENTAIRE</center></span>
@endif
</div>

@include('pagination.default', ['paginator' => $avis])