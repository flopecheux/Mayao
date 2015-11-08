@extends('master')

@section('content')
<div class="pageload"><img src="img/loading.gif"></div>

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content myprofil">
    <div class="wrapper">
        
        <div class="resp_profil">
            <div class="col2_profil">
                <img src="{{ $user->photo }}" class="avatar">
                <h1 class="xltext">{{ $user->prenom }}<br>{{ $user->nom }}</h1>
                <div class="clear"></div>
                <div class="infos">
                    ÂGE <h3 class="tblue">{{ Carbon::now()->diffInYears(Carbon::createFromFormat('Y-m-d', $user->date_naissance)) }} ANS</h3><br>
                    VILLES <h3 class="tblue">
                    @foreach($user->ps->list_villes as $key => $villes)
                        @if($key != 0) / @endif
                        {{ $villes }}
                    @endforeach
                    </h3><br>
                    NOTE 
                    @if($user->ps_avis->count() > 0)
                    <div class="score" data-score="{{ $user->ps->note }}"></div> 
                    <a href="/avis">lire les {{ $user->ps_avis->count() }} avis</a><br>
                    @else
                    <span class="tblue">Aucun avis</span><br>
                    @endif
                    CATÉGORIE <h2 class="tblue">
                    @if($user->ps->specialite == 'H')
                    {{ trans('global.man') }}
                    @elseif($user->ps->specialite == 'F')
                    {{ trans('global.woman') }}
                    @else
                    {{ trans('global.man') }} & {{ trans('global.woman') }}
                    @endif
                    </h2><br>
                    MARQUES FÉTICHES<br> <h3 class="tblue">
                    @foreach($user->marques as $key => $marqueps)
                        @if($key != 0) / @endif
                        {{ $marqueps->marque->nom }}
                    @endforeach
                    </h3><br>
                    INSPIRATIONS<br> <h3 class="tblue">
                    @foreach($user->ps->list_icones as $key => $icones)
                        @if($key != 0) / @endif
                        {{ $icones }}
                    @endforeach
                    </h3>
                </div>
                <h3 class="thintext mtext">
                    {{ $user->ps->pitch }}
                </h3>
            </div>

            <div class="photos_profil">
                @foreach($user->photos as $photo)
                <img class="photo" src="{{ $photo->url }}" alt="">
                @endforeach
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="col1_profil">
            @if(Session::has('rps'))
            <a href="back" data-rcount="{{ Session::get('rcount') }}"><img src="./img/Forme-23.png"> RETOUR À<br>LA RECHERCHE</a>
            @elseif(Session::has('espace'))
            <a href="/espace"><img src="./img/Forme-23.png"> RETOUR À<br>MON ESPACE</a>
            @else
            <a href="/"><img src="./img/Forme-23.png"> RETOUR À<br>L'ACCUEIL</a>
            @endif
            <div class="title"><span>SERVICES</span></div>
            <span class="smtext thintext">
                <h2>PERSONAL SHOPPING <span class="bold">{{ $user->ps->tarif_sa }}€ / h</span></h2><br><br>
                <span class="tgrey">
                    <u><i>bientôt disponible</i></u><br>
                    GESTION GARDE-ROBE<br>
                    E-SHOPPING<br>
                    SHOPPING À DISTANCE<br>
                    SHOPPING EXPRESS
                </span>
            </span>
            <div class="title"><span><h2>DISPONIBILITÉS</h2></span></div>
            <div id="dispo"></div>
            <a href="/reserver" class="button">RÉSERVER</a>
        </div>
        
        <div class="clear"></div>
        
    </div>
    @if(Session::has('rps') && Session::get('rps')->count() > 1)
    <div class="pdispo">
        <span class="title">PROFILS DISPONIBLES</span>
        <div class="minprofil">
            @foreach(Session::get('rps') as $rps)
            @if($rps->id != $user->id)
            <a href="/profil/{{ $rps->id }}" class="minp">
                <img src="{{ $rps->photo }}">
                {{ str_limit(strtoupper($rps->prenom).' '.strtoupper(substr($rps->nom, 0, 1)), 8) }}<br>
                <span class="tblue thintext"><i>(PARIS)</i></span>
                <div class="score" data-score="{{ $rps->ps->note }}"></div>
            </a>
            @endif
            @endforeach
        </div>
        <a href="" class="plus"><img src="./img/plus.png"></a>
        <div class="clear"></div>
    </div>
    @endif
</div>

<div class="popup reserver hvcenter">
    <a href="#" class="close_popup">X</a>
    <span class="xltext">RÉSERVER</span>
    <div class="border" style="margin-bottom: 20px;"></div>
    <div class="left" style="text-align: left;">
        <div style="padding-bottom: 10px;">CHOISISSEZ UNE DATE</div>
        <div id="dispo2"></div>
    </div>
    <div class="left" style="text-align: left; padding-left: 30px;"><div class='card-wrapper'></div>
    {!! Form::open(array('url' => '/reserver', 'method' => 'post')) !!}
        <input type="hidden" name="date">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div style="padding-bottom: 10px;">SERVICE SOUHAITÉ</div>
        <select type="text" name="service" id="service" style="width:100%;">
            <option value="sa">PERSONAL SHOPPING</option>
            <option value="gd" disabled>GESTION GARDE-ROBE</option>
            <option value="es" disabled>E-SHOPPING</option>
            <option value="sd" disabled>SHOPPING À DISTANCE</option>
            <option value="se" disabled>SHOPPING EXPRESS</option>
        </select><br>
        <div style="padding-top: 20px; padding-bottom: 10px;">HORAIRES</div>
        <select type="text" id="horaires1" name="horaire1" style="width:60px" disabled>
        </select> À
        <select type="text" id="horaires2" name="horaire2" style="width:60px" disabled>
        </select><br>
        <div style="padding-top: 20px; padding-bottom: 10px;" class="thintext xltext">TOTAL <span class="tarif bold">20€</span></div>
        <button class="button" style="margin-top: 25px;" type="submit">VALIDER</button>
    {!! Form::close() !!} 
    </div>
</div>

<div class="popup avis hvcenter" style="text-align:left;">
    <a href="#" class="close_popup">X</a>
    @if($avis->count() > 0)
    @foreach($avis as $a)
    <u><a href="#">{{ strtoupper($a->user->prenom.' '.$a->user->nom) }}</a></u>
    <div class="score min" data-score="{{ $a->note }}"></div><br><br>
    <span class="thintext">{{ $a->commentaire }}</span><br><br>
    @endforeach
    @include('pagination.default', ['paginator' => $avis])
    @else
        <span class="thintext"><center><br><br>AUCUN AVIS</center></span>
    @endif
</div>
@endsection

@section('includejs')
<script type="text/javascript" src="js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="js/masonry.pkgd.min.js"></script>
@endsection

@section('customjs')
    var $container = $('.photos_profil');
    var $container2 = $('.minprofil');

    $container.imagesLoaded()
    .always( function( instance ) {

        $container.masonry({
            itemSelector: '.photo',
            columnWidth: '.photo',
            gutter: 15
        });

        $container2.imagesLoaded()
        .always( function( instance ) {
            $container2.masonry({
                itemSelector: '.minp',
                columnWidth: '.minp',
                gutter: 15
            });
            pdispo_abs();
            $(".pageload").fadeOut("slow");
        })
        .progress( function( instance, image ) {
            if(!image.isLoaded) {
                image.img.src = "/img/avatar.png";
            }
        });

    })
    .progress( function( instance, image ) {
        if(!image.isLoaded) {
            image.img.src = "/img/avatar.png";
        }
    });
    
    $('a[href="back"]').click(function(e) {
        e.preventDefault();
        var t = $(this);
        $.get("{{ url() }}/profil/clear", function(data) {
            if(data.response == 'ok') {
                window.history.go('-'+t.attr('data-rcount'));
            }
        });
    });

    $( ".pdispo>.plus" ).click(function(e) {
        e.preventDefault();
        if($( window ).width() > 1100 ) { var h = 104; } else { var h = 80; }
        if($('.pdispo').hasClass( "active" )) {
            $('.pdispo').css('height', h).removeClass( "active" );
        } else {
            $('.pdispo').css('height', $('.pdispo>.minprofil').height() - 5).addClass( "active" );
        }
    });

    function pdispo_abs() {
        var hm = $('.wrapper').height() + $('.wrapper').offset().top + $('.pdispo').height() + 60;
        if($(window).height() > hm) {
            $('.pdispo').addClass('abs');
        } else {
            $('.pdispo').removeClass('abs');
        }
    }

    $(window).resize(function() {
        pdispo_abs();
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

    var dispDates = {!! $disp !!};
    var indispDates = {!! $indisp !!};
    var recDates = {!! $rec !!};

    function rec(date) {
      var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
      var day = days[ date.getDay() ];
      if ($.inArray(day, recDates) != -1) {
        return true;
      } else {
        return false;
      }
    }

    function disp(date) {
      dmy = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
      if ($.inArray(dmy, dispDates) != -1) {
        return true;
      } else {
        return false;
      }
    }

    function indisp(date) {
      dmy = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
      if ($.inArray(dmy, indispDates) == -1) {
        return true;
      } else {
        return false;
      }
    }

    $('#dispo').datepicker({ beforeShowDay:
      function(date) { 
        return [ disp(date) || (indisp(date) && rec(date)), "" ];
      }, 
      onSelect: function(date, inst) {
        $("#dispo2").datepicker("setDate", $("#dispo").datepicker("getDate"));
        $("#dispo2 a.ui-state-active").click();
      },
      minDate: 2
    }).find(".ui-state-active").removeClass("ui-state-active");

    var horaires = [];
    var tarif_sa = {{ $user->ps->tarif_sa }};

    $('#dispo2').datepicker({ 
        beforeShowDay: function(date) { 
            return [ disp(date) || (indisp(date) && rec(date)), "" ];
        }, 
        dateFormat: 'yy-mm-dd',
        altField: 'input[name="date"]',
        altFormat: "yy-mm-dd",
        onSelect: function(date, inst) {
            jQuery.ajax({
                type: 'POST',
                data: {date: date, id: {{ $user->id }} },
                dataType: 'json',
                url: '{{ url() }}/reserver/date'
            }).done(function (data) {

                if (data.success == true) {
                    $("#horaires1>option").remove();
                    horaires = data.horaires;
                    for (horaire of data.horaires) {
                        $("select#horaires1").append('<option value="' + horaire + '">' + horaire + 'H</option>');
                    }
                    $("#horaires1").selectmenu("enable");
                    $("#horaires1").selectmenu("refresh");

                    $("#horaires2>option").remove();
                    var h2 = parseInt($("#horaires1").val())+1;
                    $("select#horaires2").append('<option value="' + h2 + '">' + h2 + 'H</option>');
                    for (horaire of horaires) {
                        if (horaire > $("#horaires1").val() && (Math.abs(horaire-h2) < 2)  && ($.inArray((horaire - 1), horaires)) !== -1) {
                            $("select#horaires2").append('<option value="' + (horaire+1) + '">' + (horaire+1) + 'H</option>');
                            var h2 = horaire;
                        }
                    }
                    $("#horaires2").selectmenu("enable");
                    $("#horaires2").selectmenu("refresh");

                    $("span.tarif").html((parseInt($("#horaires2").val()) - parseInt($("#horaires1").val())) * tarif_sa.toFixed(2) + '€');
                } else {
                    notif(false, data.msg);
                }

            }).fail(function () {
                notif(false, 'Il y a eu un problème lors de la requête.');
            });
            $("#dispo").datepicker("setDate", $("#dispo2").datepicker("getDate"));
        }, 
        minDate: 2
    }).find(".ui-state-active").removeClass("ui-state-active");

    $('a[href="/reserver"], .close_popup').click(function(e) {
        e.preventDefault();
        if (overlay.is(':visible')) {
            $('.reserver').fadeOut(500)
            overlay.fadeTo('500', 0, function() {
                overlay.hide();
            });
        } else {
            $('.reserver').fadeIn(500);
            overlay.show(0, function() {
                overlay.fadeTo('500', 0.5);
            });
            window.scroll(0,0);
        }
    });

    $('a[href="/avis"], .close_popup').click(function(e) {
        e.preventDefault();
        if (overlay.is(':visible')) {
            $('.avis').fadeOut(500)
            overlay.fadeTo('500', 0, function() {
                overlay.hide();
            });
        } else {
            $('.avis').fadeIn(500);
            overlay.show(0, function() {
                overlay.fadeTo('500', 0.5);
            });  
        }
    });

    $('.avis').on('click', '.pagination a', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'GET',
            dataType: 'json',
            url: '{{ url('avis').'/'.$user->id }}' + '?page=' + $(this).attr('href').split("?page=")[1]
        }).done(function (data) {
            $('.avis').html(data.html);
            $('.score').raty({
              score: function() {
                return $(this).attr('data-score');
              }
            });
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    });

    $( "#service" ).selectmenu({
        width: 270
    });

    $( "#horaires1" ).selectmenu({
        select: function( event, ui ) {
            $("#horaires2>option").remove();
            var h2 = parseInt(ui.item.value)+1
            $("select#horaires2").append('<option value="' + h2 + '">' + h2 + 'H</option>');
            for (horaire of horaires) {
                if (horaire > ui.item.value && (Math.abs(horaire-h2) < 2) && ($.inArray((horaire - 1), horaires)) !== -1) {
                    $("select#horaires2").append('<option value="' + (horaire+1) + '">' + (horaire+1) + 'H</option>');
                    var h2 = horaire;
                }
            }
            $("#horaires2").selectmenu("enable");
            $("#horaires2").selectmenu("refresh");

            $("span.tarif").html((parseInt($("#horaires2").val()) - parseInt($("#horaires1").val())) * tarif_sa.toFixed(2) + '€');
        }
    });

    $( "#horaires2" ).selectmenu({
        select: function( event, ui ) {
            $("span.tarif").html((parseInt($("#horaires2").val()) - parseInt($("#horaires1").val())) * tarif_sa.toFixed(2) + '€');
        }
    });
@endsection