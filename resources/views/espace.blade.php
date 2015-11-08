@extends('master')

@section('content')
<div class="pageload"><img src="img/loading.gif"></div>

@include('nav', ['fixed' => 'fixed', 'rv' => true])

<div class="navtop fixed"></div>

<div class="content espace vh">
    <div class="wrapper">
       
        <div class="infoprofil">
            <div class="profil">
                <img src="{{ $user->photo }}" class="avatar">
                <a href="/update" class="smtext thintext pad">> modifier</a>
                BIENVENUE<br>
                <span style="float: left; width: 145px; word-wrap: break-word; /*-webkit-hyphens: auto; -moz-hyphens: auto; -ms-hyphens: auto; -o-hyphens: auto; hyphens: auto;*/" class="xltext">{{ $user->prenom }} {{ $user->nom }}</span>
                <div class="clear"></div>
            </div>
            <div class="plus">
                <div class="info">
                    INFOS
                    <a href="/update" class="smtext thintext right mg">> modifier</a>
                    <div class="border"></div>
                    <div class="mtext infos">
                        DATE DE NAISSANCE <span class="thintext tgreen">{{ Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y') }}</span><br>
                        EMAIL <span class="thintext tgreen">{{ $user->email }}</span><br>
                        TÉL <span class="thintext tgreen">{{ $user->tel }}</span><br>
                        ADRESSE <span class="thintext tgreen">{{ $user->adresse }}, {{ $user->codepostal }} {{ $user->ville }}</span>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="tabs left">
            <ul>
                <li>
                    <a href="/espace/planning" class="active"><img src="./img/Forme-29.png"></a>
                    @if($commandes->count() > 0)
                    <span class="badge">{{ $commandes->count() }}</span>
                    @endif
                </li>
                <li><a href="/espace/paiements"><img src="./img/Forme-42.png"></a></li>
            </ul>
            <div class="ctab">
                <div class="center">PLANNING</div>
                <div class="border" style="margin-bottom:15px;"></div>

                <div class="ctn">
                @if($commandes->count() > 0)
                    @foreach($commandes as $commande)
                    <?php $horaires = explode(',', $commande->horaires); ?>
                    <span class="tgreen"><u>{{ strtoupper(Carbon::createFromFormat('Y-m-d', $commande->date)->formatLocalized('%A %d %B')) }}</u></span><br><br>
                    <span class="thintext">PERSONAL SHOPPER</span> <a href="profil/{{ $commande->userps->id }}" style="color:black !important;">{{ strtoupper($commande->userps->prenom.' '.$commande->userps->nom) }}</a><br>
                    <span class="thintext">HORAIRE</span> {{ $horaires[0] }}H-{{ end($horaires) + 1 }}H<br><br>
                    @if($commande->date <= Carbon::now()->toDateString())
                    <a href="/note/{{ $commande->id }}" class="thintext">> Laissez votre avis</a><br><br>
                    @endif
                    @endforeach
                @else
                    <span class="thintext"><center><br><br>VOUS N'AVEZ FAIT AUCUNE RÉSERVATION</center></span>
                @endif
                @include('pagination.default', ['paginator' => $commandes])
                </div>
            </div>
        </div>
         
        <div class="tabs right">
            <ul>
                <li><a href="/espace/commentaires" class="active"><img src="./img/Forme-33.png"></a></li>
                <li>
                    <a href="/espace/messages"><img src="./img/Forme-40.png"></a>
                    @if($nbmsg > 0)
                    <span class="badge">{{ $nbmsg }}</span>
                    @endif
                </li>
                <li><a href="/espace/message/new"><img src="./img/MergedLayers.png"></a></li>
            </ul>
            <div class="ctab">
                <div class="center">COMMENTAIRES</div>
                <div class="border" style="margin-bottom:15px;"></div>

                <div class="ctn">
                @if($avis->count() > 0)
                    @foreach($avis as $a)
                    <u><a href="#">{{ mb_strtoupper($a->userps->prenom.' '.$a->userps->nom) }}</a></u>
                    <div class="score min" data-score="{{ $a->note }}"></div><br><br>
                    <span class="thintext">{{ $a->commentaire }}</span><br><br>
                    @endforeach
                @else
                    <span class="thintext"><center><br><br>VOUS N'AVEZ FAIT AUCUN COMMENTAIRE</center></span>
                @endif
                </div>

                @include('pagination.default', ['paginator' => $avis])
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>

<div class="navbottom fixed"></div>
@endsection

@section('customjs')

    $(this).ajaxStop(function () {
        $('.score').raty({
                readOnly: true,
                score: function() {
                return $(this).attr('data-score');
            }
        });
        $( "#user" ).selectmenu();
        $('.loader').hide();
    });

    $(window).bind("load", function() {
        $(".pageload").fadeOut("slow");
    });

    $('.tabs>ul>li>a').click(function(e) {
        e.preventDefault();
        var tab = $(this);
        tab.closest('.tabs').find('.active').removeClass('active');
        jQuery.ajax({
            type: 'GET',
            dataType: 'json',
            url: '{{ url() }}' + tab.attr('href')
        }).done(function (data) {
            tab.closest('.tabs').find('.ctab').html(data.html);
            tab.addClass('active');
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    });

    $('.ctab').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var a = $(this);
        jQuery.ajax({
            type: 'GET',
            dataType: 'json',
            url: a.attr('href')
        }).done(function (data) {
            a.closest('.tabs').find('.ctab').html(data.html);
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    });

    $('.ctab').on('click', 'button[type="submit"]', function(e) {
        e.preventDefault();
        var url = $(this).closest('.tabs').find('form').attr('action');
        var data = $(this).closest('.tabs').find('form').serializeArray();
        jQuery.ajax({
            type: 'POST',
            data : data,
            url: url
        }).done(function (data) {
            if(data.success == true) {
                notif(true, data.msg);
            } else {
                notif(false, data.msg);
            }
            if(data.newmsg == true) {
                $('a[href="/espace/message/new"]').click();
            }
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    });
@endsection