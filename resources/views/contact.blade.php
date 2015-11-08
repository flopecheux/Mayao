@extends('master', ['title' => 'MAYAO, contact – Personal shopping', 'meta' => 'Vous avez une question sur le personal shopping ou souhaitez tout simplement en savoir plus sur notre concept ? Dites-nous tout !'])

@section('content')

@include('nav', ['fixed' => 'fixed', 'ps' => true])

<div class="navtop fixed"></div>

        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg2_jaune_motif.png);">
                <div class="thintext center" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px;">
                    <div class="bold xxltext" style="margin-bottom:40px;">CONTACT</div>
                    06 77 10 77 18<br>
                    <a href="mailto:contact@mayao.fr">contact@mayao.fr</a><br><br>
                    <a href="https://twitter.com/mayao_fr" target="_blank">
                    	<img src="./img/logo-twitter-noir.png" style="height: 40px;vertical-align: middle;margin-right: 10px;">
                    	@mayao_fr
                    </a>
                </div>
            </div>
        </div>

<div class="navbottom fixed"></div>

@endsection