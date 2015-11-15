@extends('master', ['title' => 'MAYAO – Personal shopping', 'meta' => 'Mayao.fr est la première plateforme dédiée au personal shopping. Efficace, attentionné et accessible ça va vous changer la vie !'])

@section('content')
<div id="fullpage">
    <div id="home" class="section">

        @include('nav', ['d'=> '1', 'ps' => true])

        <div class="navtop"></div>
        
        <div class="thv">
            <div class="hvcontent center home">
                <div class="search">
                    <span><h1>{{ trans('global.whereshop') }}</h1></span><br>
                    {!! Form::open(array('url' => '/recherche', 'method' => 'post')) !!}
                    <input type="text" name="ville" placeholder="Paris, Lyon ...">
                    <button type="submit"></button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        
        <div id="how" class="navbottom">
            <a href="#how">{{ trans('global.how') }}</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>
    
    <div id="how" class="section">
       
        @include('nav', ['d'=> '2', 'ps' => true])

        <div class="navtop"></div>
        
        <div class="thv">
            <div class="hvcontent center how">
                <div class="search">
                    <span><h1>{{ trans('global.whereshop') }}</h1></span><br>
                    {!! Form::open(array('url' => '/recherche', 'method' => 'post')) !!}
                    <input type="text" name="ville" placeholder="Paris, Lyon ...">
                    <button type="submit"></button>
                    {!! Form::close() !!}
                </div>

                <div class="center">
                    <span class="title">{{ trans('global.how') }}</span><br>
                    <img src="./img/flechehow.png" class="fleche">
                    <div class="content_text">
                        <span class="text">
                            <span class="number"><img src="./img/1.png"></span>
                            <h3>{{ trans('global.how_1') }}</h3>
                        </span>
                        <span class="text">
                            <span class="number"><img src="./img/2.png"></span>
                            <h3>{{ trans('global.how_2') }}</h3>
                        </span>
                        <span class="text">
                            <span class="number"><img src="./img/3.png"></span>
                            <h3>{{ trans('global.how_3') }}</h3>
                        </span>
                    </div>
                    <br>
                    <img src="./img/vagues.png" class="vagues">
                </div>
            </div>
        </div>
        
        <div id="what" class="navbottom">
            <a href="#what">LE PERSONAL SHOPPING C'EST QUOI ?</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>
    

    <div id="vid" class="section scroll">
       
        @include('nav', ['d' => 7, 'ps' => true])

        <div class="navtop"></div>

        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg3_bleu_motif.png);">
                <div class="thintext" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px; text-align: justify; text-justify: inter-word;">
                    <iframe id="player" type="text/html" width="1450" height="600"
  src="https://www.youtube.com/embed/HAK2faFqZ6o"
  frameborder="0"></iframe>
                </div>
            </div>
        </div>

        <div id="who" class="navbottom">
            <a href="#who">LE PERSONAL SHOPPING C'EST QUOI ?</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>




    <div id="what" class="section scroll">
       
        @include('nav', ['d' => 3, 'ps' => true])

        <div class="navtop"></div>

        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg2_jaune_motif.png);">
                <div class="thintext" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px; text-align: justify; text-justify: inter-word;">
                    <div class="bold center xxltext" style="margin-bottom:60px;">Le personal shopping c'est quoi ?</div>
                    C'est <i><span class="bold">EFFICACE</span>, <span class="bold">ACCESSIBLE</span></i> et <i><span class="bold">AGRÉABLE</span></i> !<br><br>
                    Le personal shopping est un <span class="bold">service sur mesure</span> dédié à votre garde-robe...et votre BIEN-ÊTRE.<br>
                    Nous ne vivons pas nus et le vêtement matérialise cette fragile cloison entre notre monde intime et public. S'habiller c'est paraître au monde, affirmer et exprimer sa personnalité. S'habiller est quotidien mais les vêtements peuvent également marquer des évènements importants de nos vies : entretien d'embauche, mariage, première rencontre...
                    Se sentir bien dans ses vêtements est un des piliers de notre <span class="bold">bien-être</span>.
                    Le personal shopping permet de répondre aux problématiques contemporaines de consommation du vêtement : manque de temps, offre pléthorique, jungle du fast fashion, pression grandissante de l'image...
                    Bénéficier d'un service de personal shopping c'est prendre du temps pour soi avec un expert qui vous veut du bien. C'est envisager le vêtement autour d'un échange pour l'inscrire dans une consommation collaborative basée sur le partage des connaissances, pour enfin en révolutionner sa consommation : plus juste et plus efficace !<br><br>
                    Mayao vous permet de trouver <span class="bold">le meilleur service</span> : celui qui vous convient.
                    <div class="bold center xxltext" style="margin-top:60px;">BIENVENUE !</div>
                </div>
            </div>
        </div>

        <div id="who" class="navbottom">
            <a href="#who">QUI SONT LES PERSONAL SHOPPERS ?</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>

    <div id="who" class="section scroll">
       
        @include('nav', ['d' => 4, 'ps' => true])

        <div class="navtop"></div>
        
        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg3_bleu_motif.png);">
                <div class="thintext" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px; text-align: justify; text-justify: inter-word;">
                    <div class="bold center xxltext" style="margin-bottom:60px;">Qui sont les personal shoppers ?</div>
                    Ce sont des <span class="bold">passionnés de mode</span> qui vous veulent du bien.<br>
    Ils possèdent une connaissance approfondie du vêtement, de ses différents courants stylistiques et sont à votre disposition pour vous mettre en valeur.<br>
    Ils <span class="bold">s'adaptent</span> à votre besoin, que ce soit pour vous accompagner et guider lors d'une virée shopping ou vous aider à trier votre garde-robe.<br><br>
    Tout est possible ! Autour du vêtement bien sûr :)
                    <div class="bold center" style="margin-top:60px;"><a href="/recherche" class="button">Découvrez les personal shoppers</a></div>
                </div>
            </div>
        </div>
        
        <div id="charter" class="navbottom">
            <a href="#charter">CHARTE ÉTHIQUE DES PERSONAL SHOPPERS</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>
    
    <div id="charter" class="section scroll">
       
        @include('nav', ['d' => 5, 'ps' => true])

        <div class="navtop"></div>
        
        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg2_jaune_motif.png);">
                <div class="thintext" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px; text-align: justify; text-justify: inter-word;">
                    <div class="bold center xxltext" style="margin-bottom:60px;">Charte éthique des personal shoppers</div>
                    Les personal shoppers présents sur MAYAO <span class="bold">s'engagent :</span><br><br>
                    <ul class="homelist">
                        ­<li><span class="bold"><u>Ecoute :</u></span> ils vous contactent en amont de votre séance pour bien définir votre besoin et ainsi la préparer avec une efficacité optimale. Pendant la séance ils s'engagent à prendre en compte votre avis et vos remarques.</li>
                        ­<li><span class="bold"><u>Rapidité :</u></span> suite à votre commande sur notre site ils vous contactent rapidement pour définir avec précision les modalités de la séance.</li>
                        ­<li><span class="bold"><u>Inventivité :</u></span> ce sont des passionnés ! Ils sauront rebondir et vous surprendre pour vous combler.</li>
                        ­<li><span class="bold"><u>Sérieux :</u></span> ce sont des experts qui s'engagent à vous donner entière satisfaction.</li>
                        ­<li><span class="bold"><u>Disponibilité :</u></span> en amont et en aval de la séance ils répondent à vos interrogations.</li>
                        ­<li><span class="bold"><u>Dynamisme :</u></span> une séance de personal shopping c'est prendre soin de vous dans la joie et la bonne humeur !</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div id="services" class="navbottom">
            <a href="#services">QUELS SONT LES DIFFÉRENTS SERVICES DE PERSONAL SHOPPING ?</a>
            <img src="./img/Forme-2.png">
        </div>
    </div>

    <div id="services" class="section scroll">
       
        @include('nav', ['d' => 6, 'ps' => true])

        <div class="navtop"></div>
        
        <div class="thv">
            <div class="hvcontent" style="background: url(./img/bg3_bleu_motif.png);">
                <div class="thintext" style="margin:0 auto; padding: 30px 10% 70px 10%; font-size:20px; text-align: justify; text-justify: inter-word;">
                    <div class="bold center xxltext" style="margin-bottom:60px;">Quels sont les différents services de personal shopping ?</div>
                    Débordés ? Déboussolés ? Curieux ? Passionnés ?<br><br>
                    <u>Choisissez parmi:</u><br><br>
                    <span class="bold">Le shopping accompagné :</span><br>
                    Votre personal shopper est à vos côtés pour vous guider et vous conseiller lors d'une séance shopping. En fonction de vos besoins il définit les boutiques pertinentes et anticipera une pré-sélection de pièces à vous présenter.<br><br>
                    <span class="bold">Gestion de garde-robe :</span><br>
                    Que vos placards soient pleins à craquer ou que vous ayez le sentiment de ne rien avoir à vous mettre chaque matin, votre personal shopper est un avis éclairé pour faire le point sur votre dressing. Les pièces à garder, les pièces à donner ou à recycler, les basics à compléter...il vous aide à définir et construire votre dressing idéal et fonctionnel.<br><br>
                    <span class="bold">Le shopping à votre place : </span><br>
                    Vous n'avez jamais le temps de faire du shopping ou vous n'appréciez pas cette activité ? Votre personal shopper s'en charge pour vous et sélectionne les pièces dont vous avez besoin et envie. Il peut se rendre sur le lieu de votre choix pour vous les livrer ainsi que vous assister et conseiller lors de l'essayage. Gardez ce que vous aimez, votre personal shopper se charge de ramener le reste !
                    <div class="bold center" style="margin-top:60px;"><a href="/recherche" class="button">Découvrez les personal shoppers</a></div>
                </div>
            </div>
        </div>
        
        <div class="navbottom">
            <a href="#home">TROUVEZ VOTRE PERSONAL SHOPPER</a>
            <img class="up" src="./img/Forme-2-haut.png">
        </div>
    </div>



</div> 
@endsection

@section('includejs')
<script type="text/javascript" src="js/ssm.min.js"></script>
<script type="text/javascript" src="js/jquery.fullPage.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script type="text/javascript" src="js/typeahead.bundle.js"></script>
<script type="text/javascript" src="js/typeahead-addresspicker.js"></script>
@endsection

@section('customjs')
    ssm.addStates([
{{--     {
        id: 'mobile',
        query: '(max-width: 820px)',
        onEnter: function(){
            $('#fullpage').fullpage({
                anchors:['home', 'how', 'vid', 'what', 'who', 'charter', 'services'],
                autoScrolling: false,
                verticalCentered: true,
                scrollOverflow: false,
                fitToSection: false
            });
        }, 
        onLeave: function(){
            $('#fullpage').fullpage.destroy('all');
            location.reload();
        }
    }, --}}
    {
        id: 'desktop',
        query: '(min-width: 820px)',
        onEnter: function(){
            $('.section, .navbottom').each(function() { 
                $(this).attr('rid', $(this).attr('id'));
                $(this).removeAttr('id'); 
            });
            $('#fullpage').fullpage({
                anchors:['home', 'how', 'vid', 'what', 'who', 'charter', 'services'],
                autoScrolling: true,
                animateAnchor:false,
                verticalCentered: false,
                //loopBottom: true,
                normalScrollElements: '.side-menu, .slimScrollDiv',
                scrollOverflow: true
            });
            var addressPicker = new AddressPicker({
              autocompleteService: {
                types: ['(cities)'], 
                componentRestrictions: { country: 'FR' }
              }
            });

            $('.section input').typeahead(null, {
              displayKey: 'description',
              source: addressPicker.ttAdapter()
            });

            $('.section input').on('typeahead:selected', function (e, datum) {
                $(this).val(datum.terms[0].value);
                $(this).closest('form').submit();
            });
        },
        onLeave: function(){
            $('#fullpage').fullpage.destroy('all');
            $('.section, .navbottom').each(function() { 
                $(this).attr('id', $(this).attr('rid'));
                $(this).removeAttr('rid'); 
            });
            $('input').typeahead('destroy');
        }
    }
    ]);
@endsection
