@extends('master', ['title' => 'MAYAO – Personal shopping', 'meta' => 'Trouvez votre personal shopper sur mayao.fr : entrez votre ville, votre budget et le service dont vous avez besoin et choisissez parmi les profils proposés'])

@section('content')
<div class="pageload"><img src="img/loading.gif"></div>

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content">
    <div class="wrapper">
        <a href="" class="button flat fbtn">AFFINEZ VOS CRITÈRES</a>
        <div class="filtres">
            {!! Form::open(array('url' => '/recherche/ajax', 'method' => 'post')) !!}
            <span class="ltext">AFFINEZ VOS CRITÈRES</span>
            <span class="border"></span>
            <span class="smtext">OÙ ÊTES-VOUS ?</span>
            <input type="text" class="vform all" name="ville" value="{{ $ville }}" placeholder="ville">
            <span class="smtext">QUAND EN AVEZ-VOUS ENVIE ?</span><br>
            <input type="text" name="date" class="vform" id="date" placeholder="Date">
            <select type="text" class="vform" id="heure" name="heure">
                <option value=""></option>
                @for($i = 8; $i < 22; $i++)
                <option value="{{ $i }}">{{ $i }}H</option>
                @endfor
            </select><br>
            <span class="smtext">QUEL EST VOTRE BUDGET ?</span><br>
            <input type="text" id="amount" value="">
            <input type="hidden" id="amount2" class="vform" name="budget" value="">
            <div id="slider-range"></div>
            <span class="smtext">SERVICE SOUHAITÉ</span>
            <ul class="service">
                <li>
                    <input type="checkbox" value="" id="sa" name="check" class="vform" checked="checked"/>
                    <label for="sa">SHOPPING ACCOMPAGNÉ</label>
                </li>
                <li>
                    <input type="checkbox" value="" id="gd" name="check" class="vform" disabled="disabled"/>
                    <label for="gd">GESTION GARDE-ROBE</label>
                </li>
                <li>
                    <input type="checkbox" value="" id="es" name="check" class="vform" disabled="disabled"/>
                    <label for="es">E-SHOPPING</label>
                </li>
                <li>
                    <input type="checkbox" value="" id="sd" name="check" class="vform" disabled="disabled"/>
                    <label for="sd">SHOPPING À DISTANCE</label>
                </li>
                <li>
                    <input type="checkbox" value="" id="se" name="check" class="vform" disabled="disabled"/>
                    <label for="se">SHOPPING EXPRESS</label>
                </li>
            </ul>
            <span class="smtext">MARQUES FÉTICHES</span>
            <div class="marques">
                <ul>
                    @foreach($marques as $marque)
                    <li>
                        <input type="checkbox" class="vform" value="{{ $marque->id }}" id="{{ $marque->id }}" name="marques[]" />
                        <label for="{{ $marque->id }}">{{ $marque->nom }}</label>
                    </li>
                    @endforeach
                </ul>
            </div>
            <span class="smtext spe">CATÉGORIE</span><br>
            <input type="radio" class="vform" value="H" id="h" name="specialite" /><label for="h">HOMME</label>
            <input type="radio" class="vform" value="F" id="f" name="specialite" /><label for="f">FEMME</label><br><br>
            <button class="button">APPLIQUER</button>
            {!! Form::close() !!}
        </div>
                                                                                                                                                                                     
        <div class="resultats">
            @if($userps->count() > 0)
            @foreach($userps as $user)
            <a href="/profil/{{ $user->id }}" class="profil" data="VOIR LE PROFIL">
                <img src="{{ $user->photo }}">
                <div class="info">
                    <span class="left">{{ mb_strtoupper($user->prenom) }} {{ mb_strtoupper(substr($user->nom, 0, 1)) }}.<br><div class="score" data-score="{{ $user->ps->note }}"></div></span>
                    <span class="right smtext">à partir<br>de {{ $user->ps->tarif_sa }}€/h</span>
                    <div class="clear"></div>
                </div>
            </a>
            @endforeach
            @else 
            AUCUN RÉSULTAT
            @endif            
        </div>

        @if($userps->hasMorePages())
        <a href="{{ $userps->nextPageUrl() }}" class="button flat more_results off">VOIR PLUS DE PROFILS</a>
        @endif

        <div class="clear"></div>
        
    </div>
</div>
@endsection

@section('includejs')
<script type="text/javascript" src="js/ssm.min.js"></script>
<script type="text/javascript" src="js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="js/imagesloaded.pkgd.min.js"></script>
<script>
(function(a){a.expr[":"].onScreen=function(b){var c=a(window),d=c.scrollTop(),e=c.height(),f=d+e,g=a(b),h=g.offset().top,i=g.height(),j=h+i;
return h>=d&&h<f||j>d&&j<=f||i>e&&h<=d&&j>=f}})(jQuery);
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);
</script>
@endsection

@section('customjs')
    var $container = $('.resultats');

    $container.imagesLoaded()
    .always( function( instance ) {
        $container.masonry({
            itemSelector: '.profil',
            columnWidth: '.profil',
            gutter: 15
        });
        $(".pageload").fadeOut("slow");
    })
    .progress( function( instance, image ) {
        if(!image.isLoaded) {
            image.img.src = "/img/avatar.png";
        }
    });

    ssm.addStates([
    {
        id: 'mobile',
        query: '(max-width: 820px)',
        onLeave: function(){
            $(".filtres").show();
        },
        onEnter: function(){
            $(window).scroll(function(){  
                load_more();
            });
        }
    },
    {
        id: 'desktop',
        query: '(min-width: 820px)',
        onEnter: function(){
            var top = $('.filtres').offset().top;
            $(window).scroll(function(){  
                load_more();
                if($(window).height() > top + $('.filtres').height() + 20) {
                    $('.filtres').css("position", 'fixed').css("bottom",'' ).css("top", top);
                } else {
                    if ($(window).scrollTop()>top-20) {
                        $('.filtres').css("position",'fixed' ).css("top", '').css("bottom",'30px' )           
                    } else {
                        $('.filtres').css("position",'' ).css("top", '').css("bottom",'' )             
                    }
                }
            });
        }
    }
    ]);

    function load_more() {
        if($('a.more_results.off').is(':visible:onScreen')) {
            $('a.more_results').removeClass('off').addClass('on');
            var page = $('a.more_results').attr('href').split("?page=")[1];
            $('a.more_results').html('CHARGEMENT ...');
            recherche(page);
        }
    }
    
    function recherche(page) {
        jQuery.ajax({
            type: 'POST',
            data : $(".filtres>form").serializeArray(),
            url: $(".filtres>form").attr('action') + '?page=' + page
        }).done(function (data) {
            if(data.count == true) {
                var $data = $(data.html).filter('.profil');
                $container.append($data).imagesLoaded()
                .always( function( instance ) {
                    if(page == 1) {
                        $container.masonry('remove', $container.masonry('getItemElements'))
                        window.scroll(0,0);
                        $container.masonry('prepended', $data, false);
                    } else {
                        $container.masonry('appended', $data, false);
                    }
                    $data.animate({ opacity: 1 });
                })
                .progress( function( instance, image ) {
                    if(!image.isLoaded) {
                        image.img.src = "/img/avatar.png";
                    }
                });
                $('.score').raty({
                  readOnly: true,
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            } else {
                $container.html(data.html);
                window.scroll(0,0);
            }
            if(data.page != false) {
                $('a.more_results').show();
                $('a.more_results').html('VOIR PLUS DE PROFILS').attr('href', data.page).removeClass('on').addClass('off');
            } else {
                $('a.more_results').hide();
            }
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    }

    $(".filtres>form").submit(function(e) {
        e.preventDefault();
        recherche(1);
    });

    $('.content').on('click', 'a.more_results', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split("?page=")[1];
        $('a.more_results').html('CHARGEMENT ...');
        recherche(page);
    });

    $('a.fbtn').click(function(e) {
        e.preventDefault();
        $('.filtres').slideToggle(function() {
            if ($('.filtres').is(':visible')) {
                $('a.fbtn').html('FERMER');
            } else {
                $('a.fbtn').html('AFFINEZ VOS CRITÈRES');
            }
        });
    });

    $(".vform").change(function() {
        $(".filtres>form").submit();
    });

    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: {{ $maxprix }}*1.2,
      values: [ 0, {{ $maxprix }} ],
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ] + "€ - " + ui.values[ 1 ] + "€" );
        $( "#amount2" ).val([ui.values[ 0 ],ui.values[ 1 ]]);
      },
      change: function( event, ui ) {
        $(".filtres>form").submit();
      }
    });

    $("#amount").val( $( "#slider-range" ).slider( "values", 0 ) + "€ - " + $( "#slider-range" ).slider( "values", 1 ) + "€");

    $("#amount2").val([$( "#slider-range" ).slider( "values", 0 ), $( "#slider-range" ).slider( "values", 1 )]);
    
    $( "#heure" ).selectmenu({
        select: function( event, ui ) {
           $(".filtres>form").submit();
        }
    });

    $( "#date" ).datepicker({
        dateFormat: "dd-mm-yy"
    });
    
    $('.marques').slimScroll({
        height: '110px',
        railVisible: true
    });

    $.datepicker.setDefaults({
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
        monthNamesShort: ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin',
            'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
        dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
        dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
        dayNamesMin: ['D','L','M','M','J','V','S'],
        weekHeader: 'Sem.',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    });
@endsection