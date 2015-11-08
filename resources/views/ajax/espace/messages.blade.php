<div class="center">MESSAGES</div>
<div class="border" style="margin-bottom:15px;"></div>

<div class="ctn">
@if($messages->count() > 0)
    @foreach($messages as $msg)
    <span class="tgreen">{{ mb_strtoupper($msg->auteur->prenom.' '.$msg->auteur->nom) }}</span>
    <a href="/message/{{ $msg->id }}#{{ $msg->id }}" class="right button flat">Voir la discussion</a><br>
    <i>Il y a {{ Carbon::now()->diffForHumans(Carbon::createFromFormat('Y-m-d H:i:s', $msg->created_at), true) }}</i><br><br>
    <span class="thintext">{{ str_limit($msg->texte, 100) }}</span>
    <br><br>
    @endforeach
@else
    <span class="thintext"><center><br><br>VOUS N'AVEZ AUCUN MESSAGE</center></span>
@endif
</div>

@include('pagination.default', ['paginator' => $messages])