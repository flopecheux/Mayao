@if($avis->count() > 0)
@foreach($avis as $a)
<u><a href="#">{{ strtoupper($a->user->prenom.' '.$a->user->nom) }}</a></u>
<div class="score min" data-score="{{ $a->note }}"></div><br><br>
<span class="thintext">{{ $a->commentaire }}</span><br><br>
@endforeach
@include('pagination.default', ['paginator' => $avis])
@else
    <span class="thintext"><center>AUCUN AVIS</center></span>
@endif