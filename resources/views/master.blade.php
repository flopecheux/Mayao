<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title or 'MAYAO' }}</title>
    <base href="{{ url() }}">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dropdown.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="{{ $meta or '' }}"/>
    <meta name="keywords" content="Mayao, personal shopping, personal shopper, style, mode, vêtements, tendance, inspiration, shopping, designer, place de marché, shopping, soirée, entretien d’embauche, femme, homme, séduction, débordé, magasins, centre commercial, boutique, bien-être, confiance, beauté, achats, conseil">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="favicon.ico" /><![endif]-->
</head>
<body>

@if(Auth::check())
<div id="dropdown-nav-mob" class="jq-dropdown jq-dropdown-anchor-right" style="margin-top:10px; position:fixed;">
    <ul class="jq-dropdown-menu">
        @if(Auth::user()->check_ps)
        <li><a href="/profil/{{ Auth::id() }}">MON PROFIL</a></li>
        @endif
        <li><a href="/espace">MON ESPACE</a></li>
        <li class="jq-dropdown-divider"></li>
        <li><a href="/logout">SE DECONNECTER</a></li>
    </ul>
</div>
@endif

<a href="{{ url() }}#home"><img src="./img/Logo.png" class="logo"></a>

<div class="bar-menu">
    <a href="" class="btn-menu"><img src="./img/bar_couture.png"></a>
    @if(Auth::check())
    <a href="#" class="prbtn" data-jq-dropdown="#dropdown-nav-mob"><img src="./img/profil.png"> <div class="anchor"></div></a>
    <div id="dropdown-nav-mob" class="jq-dropdown jq-dropdown-relative jq-dropdown-anchor-right" style="margin-top:20px;">
        <ul class="jq-dropdown-menu">
            @if(Auth::user()->check_ps)
            <li><a href="/profil/{{ Auth::id() }}">MON PROFIL</a></li>
            @endif
            <li><a href="/espace">MON ESPACE</a></li>
            <li class="jq-dropdown-divider"></li>
            <li><a href="/logout">SE DECONNECTER</a></li>
        </ul>
    </div>
    @else
    <a href="" class="cobtn"><img src="./img/Connexion-Inscription.png"></a>
    @endif
</div>

<div class="side-menu">
    <div class="menu">
        <div class="links">
            <a href="{{ url() }}#what"><h3>LE PERSONAL SHOPPING C'EST QUOI ?</h3></a>
            <span class="border"></span>
            <a href="{{ url() }}#who"><h3>QUI SONT LES PERSONAL SHOPPERS ?</h3></a>
            <span class="border"></span>
            <a href="{{ url() }}#charter">CHARTE ÉTHIQUE DU PERSONAL SHOPPER</a>
            <span class="border"></span>
            <a href="{{ url() }}#services"><h3>QUELS SONT LES DIFFÉRENTS SERVICES DE PERSONAL SHOPPING ?</h3></a>
            <span class="border"></span>
            <a href="{{ url('/infographie_mayao.pdf') }}" target="_blank"><h3>LA MODE, LA MODE, LA MODE... EN CHIFFRES</h3></a>
            <span class="border"></span>
            <a href="" style="margin-bottom:10px; display:block; color:white;">SUIVEZ-NOUS</a>
            <a href="https://www.facebook.com/mayaoblog" target="_blank" style="margin-right:5px;"><img src="./img/icone-fb.png"></a>
            <a href="https://instagram.com/mayao_fr" target="_blank" style="margin-right:5px;"><img src="./img/icone-insta.png"></a>
            <a href="https://twitter.com/mayao_fr" target="_blank" style="margin-right:5px;"><img src="./img/icone-twitter.png"></a>
            <a href="https://pinterest.com/mayao_fr" target="_blank" style="margin-top:2px;"><img src="./img/pinterest.png"></a>
            <span class="border"></span>
            <a href="http://blog.mayao.fr" target="_blank" style="font-family: Perpetua; font-size: 18px;">MAYAO, LE BLOG</a>
            <span class="border"></span>
            <a href="{{ url('contact') }}">CONTACT</a>
            <span class="border"></span>
        </div>
        <div class="copyright thintext">
        © 2015 MAYAO<br>
        TOUS DROITS RÉSERVÉS<br>
        <a href="/cgu">CGU</a> - <a href="/cgv">CGV</a> - <a href="/mentions">MENTIONS LÉGALES</a>
        </div>
    </div>
    <a href=""><img src="./img/Btn-Menu.png" class="btn-menu"></a>
</div>

<div class="icons">
    <a href="https://facebook.com/mayaoblog" target="_blank"><img src="./img/Picto-Facebook.png"></a>
    <a href="https://twitter.com/mayao_fr" target="_blank"><img src="./img/Picto-Twitter.png"></a>
    <a href="https://instagram.com/mayao_fr" target="_blank"><img src="./img/Picto-Instagram.png"></a>
    <a href="https://pinterest.com/mayao_fr" target="_blank"><img src="./img/Picto-Pinterest.png"></a>
</div>

@if($errors->all())
<div class="notif error"> 
    @foreach($errors->all() as $error)
    {!! $error !!}<br>
    @endforeach
</div>
@endif

@if(Session::has('success'))
<div class="notif success"> 
   {!! Session::get('success') !!}
</div>
@endif

@if(Session::has('status'))
<div class="notif success"> 
   {{ Session::get('status') }}
</div>
@endif

@if(!Auth::check())
<div class="popup login hvcenter">
    <a href="#" class="close_popup">X</a>
    <span class="xltext">{{ trans('global.login') }}</span>
    {!! Form::open(array('url' => '/login', 'method' => 'post')) !!}
        {!! Form::text('email', old('email'), array('placeholder' => 'Email')) !!}<br>
        {!! Form::password('password', array('placeholder' => trans('global.password'))) !!}<br>
        <a href="/password/email" class="smtext">{{ trans('global.forgotten_pass') }}</a><br>
        <button class="button" type="submit">{{ trans('global.validate_login') }}</button>
        <br><a href="/register" class="mobreg button smtext">INSCRIPTION</a>
    {!! Form::close() !!}
</div>
@endif

@yield('content')

<div class="overlay"></div>
</body>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.raty.js"></script>
<script type="text/javascript" src="js/jquery.dropdown.min.js"></script>
<script type="text/javascript" src="js/nprogress.js"></script>
@yield('includejs')
<script>
$(document).ready(function() {

    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $(this).ajaxStart(function () {
        NProgress.start();
    });

    $(this).ajaxStop(function () {
        NProgress.done();
    });

    $('.score').raty({
      readOnly: true,
      score: function() {
        return $(this).attr('data-score');
      }
    });

    if($('.hvcenter').height() > ($(window).height() - 170)) {
        $(this).removeClass('hvcenter');
    }

    function notif(success, msg) {
        $(".notif").remove();
        if (success == true) {
            $("body").append('<div class="notif success">' + msg + '</div>');
        } else {
            $("body").append('<div class="notif error">' + msg + '</div>');
        }
        $(".notif").slideDown(500).delay(2000).fadeOut(500);
    }

    // show sidebar and overlay
    function showSidebar() {
        if($( window ).width() > 820) {
            sidebar.css('margin-left', '0');
        } else {
            sidebar.css('margin-top', '0');
        }
        overlay.show(0, function() {
            overlay.fadeTo('500', 0.5);
        });   
    }

    // hide sidebar and overlay
    function hideSidebar() {
        if($( window ).width() > 820) {
            sidebar.css('margin-left', (sidebar.width() * -1 + 80 ) + 'px');
        } else {
            sidebar.css('margin-top', (sidebar.height() * -1 ) + 'px');
        }
        overlay.fadeTo('500', 0, function() {
            overlay.hide();
        });
    }

    // selectors
    var sidebar = $('.side-menu');
    var button = $('.btn-menu');
    var overlay = $('.overlay');

    // add height to content area
    overlay.parent().css('min-height', 'inherit');

    sidebar.show(0, function() {
        sidebar.css('transition', 'all 0.5s ease');
    });

    // toggle sidebar on click
    button.click(function() {
        if (overlay.is(':visible')) {
            hideSidebar();
        } else {
            showSidebar();
        }

        return false;
    });

    // hide sidebar on overlay click
    overlay.click(function() {
        if($('.popup').is(':visible')) {
            $('.popup').fadeOut(500)
            overlay.fadeTo('500', 0, function() {
                overlay.hide();
            });
        } else {
            hideSidebar();
        }
    });

    $('.links a:not([target])').click(function(e) {
        e.preventDefault();
        document.location.href = $(this).attr('href');
        hideSidebar();
    });

    $('.button.c, .cobtn img, .close_popup').click(function(e) {
        e.preventDefault();
        if (overlay.is(':visible')) {
            $('.login').fadeOut(500)
            overlay.fadeTo('500', 0, function() {
                overlay.hide();
            });
        } else {
            $('.login').fadeIn(500);
            overlay.show(0, function() {
                overlay.fadeTo('500', 0.5);
            });  
        }
    });

    $('.notif').slideDown(500).delay(3500).fadeOut(500);

    $(document).keyup(function(e) {
      if (e.keyCode == 27 && overlay.is(':visible')) {
        if($('.popup').is(':visible')) {
            $('.popup').fadeOut(500)
                overlay.fadeTo('500', 0, function() {
                overlay.hide();
            });
        } else {
            hideSidebar();
        }
      }
    });

    @yield('customjs')

});

// Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-69279311-1', 'auto');
ga('send', 'pageview');
</script>
</html>