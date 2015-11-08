@if($count)
@foreach($ps as $p)
<a href="/profil/{{ $p->id }}" class="profil" data="VOIR LE PROFIL" style="opacity: 0;">
    <img src="{{ $p->photo }}">
    <div class="info">
        <span class="left">{{ mb_strtoupper($p->prenom) }} {{ mb_strtoupper(substr($p->nom, 0, 1)) }}.<br><div class="score" data-score="{{ $p->ps->note }}"></div></span>
        <span class="right smtext">à partir<br>de {{ $p->ps->tarif_sa }}€/h</span>
        <div class="clear"></div>
    </div>
</a>
@endforeach
@else 
AUCUN RÉSULTAT
@endif
