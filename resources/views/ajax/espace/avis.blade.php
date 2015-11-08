<div class="center">COMMENTAIRES</div>
<div class="border" style="margin-bottom:15px;"></div>

<div class="ctn">
@if($avis->count() > 0)
    @foreach($avis as $a)
    <u><a href="profil/{{ $a->userps->id }}">{{ mb_strtoupper($a->userps->prenom.' '.$a->userps->nom) }}</a></u>
    <div class="score min" data-score="{{ $a->note }}"></div><br><br>
    <span class="thintext">{{ $a->commentaire }}</span><br><br>
    @endforeach
@else
    <span class="thintext"><center><br><br>VOUS N'AVEZ FAIT AUCUN COMMENTAIRE</center></span>
@endif
</div>

@include('pagination.default', ['paginator' => $avis])