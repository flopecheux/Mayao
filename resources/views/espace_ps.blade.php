@extends('master')

@section('content')
<div class="pageload"><img src="img/loading.gif"></div>
    
@include('nav', ['fixed' => 'fixed'])

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
                        ADRESSE <span class="thintext tgreen">{{ $user->adresse }}, {{ $user->codepostal }} {{ $user->ville }}</span><br>
                        @if($user->check_ps)
                        CATÉGORIE <span class="thintext tgreen">
                            @if($user->ps->specialite == 'H')
                            {{ trans('global.man') }}
                            @elseif($user->ps->specialite == 'F')
                            {{ trans('global.woman') }}
                            @else
                            {{ trans('global.man') }} & {{ trans('global.woman') }}
                            @endif</span>
                        @endif
                    </div>
                </div>
                <div class="stats">
                    STATISTIQUES
                    <div class="border"></div>
                    <div class="bulle left"><img src="./img/Forme-25.png"><br>{{ $user->ps->visites }}</div>
                    <div class="bulle left mg"><img src="./img/Forme-26.png"><br>-</div>
                    <div class="bulle right"><img src="./img/Forme-39.png"><br>-</div>
                    <div class="clear"></div>
                    <span class="textbulle left">VISITES DU PROFIL</span>
                    <span class="textbulle left mg">PERSONAL SHOPPING</span>
                    <span class="textbulle right">PORTE MONNAIE</span>
                    <div class="clear"></div><br>
                    <!--
                    <div class="textstat">
                        <span class="bold">172</span> SHOPPERS VOUS SUIVENT<br>
                        <span class="bold">252</span> SHOPPERS AIMENT VOTRE PROFIL<br>
                        <span class="bold">56</span> SHOPPERS VOUS RECOMMANDENT
                    </div>
                    -->
                </div>
                <div class="eval">
                    ÉVALUATIONS
                    <div class="border"></div>
                    <span class="ltext tgreen">{{ $user->ps->note }} <i class="thintext">({{ $user->ps_avis->count() }} avis)</i></span><br>
                    <div class="score" data-score="{{ $user->ps->note }}"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        @if(Session::has('dispo'))
        <div class="infodispo">
            <img src="./img/horloge.png" align="left" style="margin-right: 20px;">
            Vous n'avez actuellement aucune disponiblité auprès des clients.<br>
            Rajoutez des disponibilités pour que les clients puissent réserver une séance avec vous.
        </div>
        @endif
        
        <div class="tabs left">
            <ul>
                <li>
                    <a href="/espace/planning" class="active"><img src="./img/Forme-29.png"></a>
                    @if($commandes->count() > 0)
                    <span class="badge">{{ $commandes->count() }}</span>
                    @endif
                </li>
                <!-- <li><a href="/espace/reservations"><img src="./img/Forme-30.png"></a></li> -->
                <li><a href="/espace/tarifs"><img src="./img/Forme-392.png"></a></li>
                <li><a href="/espace/paiements"><img src="./img/Forme-42.png"></a></li>
            </ul>
            <div class="ctab">
                <div class="center">PLANNING</div>
                <div class="border" style="margin-bottom:15px;"></div>

                <div class="ctn">
                @if($commandes->count() > 0)
                    @foreach($commandes as $commande)
                    <?php $horaires = explode(',', $commande->horaires); ?>
                    <span class="tgreen"><u>{{ mb_strtoupper(Carbon::createFromFormat('Y-m-d', $commande->date)->formatLocalized('%A %d %B')) }}</u></span><br><br>
                    <span class="thintext">CLIENT</span> {{ mb_strtoupper($commande->user->prenom.' '.$commande->user->nom) }}<br>
                    <span class="thintext">HORAIRE</span> {{ $horaires[0] }}H-{{ end($horaires) + 1 }}H<br><br>
                    @endforeach
                @else
                    <span class="thintext"><center><br><br>VOUS N'AVEZ AUCUNE RÉSERVATION</center></span>
                @endif
                @include('pagination.default', ['paginator' => $commandes])
                </div>
            </div>
        </div>

        <div class="tabs right">
            <ul>
                <li><a href="/espace/presentation" class="active"><img src="./img/Forme-38.png"></a></li>
                <li><a href="/espace/photos"><img src="./img/Forme-36.png"></a></li>
                <li><a href="/espace/disponibilites"><img src="./img/horloge.png"></a></li>
            </ul>
            <div class="ctab register">
                <div class="center">PRÉSENTATION</div>
                <div class="border" style="margin-bottom:15px;"></div>
                {!! Form::open(array('url' => '/espace/presentation/update', 'method' => 'post')) !!}
                    <span class="smtext">{{ trans('global.pitch_r') }}</span>
                    {!! Form::textarea('pitch', $user->ps->pitch, array('placeholder' => trans('global.pitch_p_r'))) !!}<br>
                    <span class="smtext">{{ trans('global.marques_f') }}</span>
                    <div class="marques">
                        <ul>
                        @foreach($marques as $marque)
                            <li>
                                @if(in_array($marque->id, $checkmarques))
                                <input type="checkbox" value="{{ $marque->id }}" id="{{ $marque->id }}" name="marques[]" checked="checked" />
                                @else
                                <input type="checkbox" value="{{ $marque->id }}" id="{{ $marque->id }}" name="marques[]" />
                                @endif
                                <label for="{{ $marque->id }}">{{ $marque->nom }}</label>
                            </li>
                        @endforeach
                        </ul>
                    </div><br>
                    <span class="smtext">{{ trans('global.icones_r') }}</span>
                    {!! Form::text('icones', $user->ps->icones, array('placeholder' => trans('global.icones_mode'))) !!}<br>
                    <span class="smtext">{{ trans('global.villes_r') }}</span>
                    <ul id="lvilles" style="padding-bottom: 10px; margin-top: 0px;"></ul>
                    {!! Form::hidden('villes', $user->ps->villes) !!}
                    {!! Form::text(null, null, array('id' => 'address', 'placeholder' => trans('global.villes_p_r'))) !!}
                    <span class="smtext">Choisissez une ou plusieurs catégories</span>
                    {!! Form::checkbox('specialite[]', 'H', ($user->ps->specialite == 'H' || $user->ps->specialite == 'HF'), ['id' => 'h']) !!}
                    <label for="h">HOMME</label>
                    {!! Form::checkbox('specialite[]', 'F', ($user->ps->specialite == 'F' || $user->ps->specialite == 'HF'), ['id' => 'f']) !!}
                    <label for="f">FEMME</label><br>
                    <button class="button" type="submit">VALIDER MES MODIFICATIONS</button><br><br>
                {!! Form::close() !!}
            </div>
        </div>
         
        <div class="tabs left">
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
                    <span class="tgreen"><u>{{ mb_strtoupper($a->user->prenom.' '.$a->user->nom) }}</u></span>
                    <div class="score min" data-score="{{ $a->note }}"></div><br><br>
                    <span class="thintext">{{ $a->commentaire }}</span><br><br>
                    @endforeach
                @else
                    <span class="thintext"><center><br><br>VOUS N'AVEZ AUCUN COMMENTAIRE</center></span>
                @endif
                </div>

                @include('pagination.default', ['paginator' => $avis])
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>

<div class="navbottom fixed">
    <a href="{{ url('profil/'.Auth::id()) }}">APERÇU DE MON PROFIL</a>
    <img src="./img/Forme-2.png">
</div>
@endsection

@section('includejs')
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script type="text/javascript" src="js/typeahead.bundle.js"></script>
<script type="text/javascript" src="js/typeahead-addresspicker.js"></script>
<script type="text/javascript" src="js/preview.js"></script>
<script type="text/javascript" src="js/dmuploader.js"></script>
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
            if (data.upload == true) { load_upload(); }
            if (data.presentation == true) { load_presentation(); }
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
        var url = $(this).closest('form').attr('action');
        var data = $(this).closest('form').serializeArray();
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
            if(data.dispo == true) {
                $('a[href="/espace/disponibilites"]').click();
            }
        }).fail(function () {
            notif(false, 'Il y a eu un problème lors de la requête.');
        });
    });

    function load_presentation() {
        $('.marques').slimScroll({
            height: '110px',
            railVisible: true
        });

        var addressPicker = new AddressPicker({
          autocompleteService: {
            types: ['(cities)'], 
            componentRestrictions: { country: 'FR' }
          }
        });

        $('#address').typeahead(null, {
          displayKey: 'description',
          source: addressPicker.ttAdapter()
        });

        var villes = [];

        if($('input[name="villes"]').val() !== "") {
            villes = $('input[name="villes"]').val().split(',');
            for(ville of villes) {
                $('#lvilles').append('<li>' + ville + ' (<font color="red" style="cursor:pointer;" ville="' + ville + '">X</font>)</li>');
            };
        };

        $('#address').on('typeahead:selected typeahead:autocomplete', function (e, datum) {
            $('#lvilles').append('<li>' + datum.description + ' (<font color="red" style="cursor:pointer;" ville="' + datum.terms[0].value + '">X</font>)</li>');
            villes.push(datum.terms[0].value);
            $('input[name="villes"]').val(villes);
            $('#address').typeahead('val', '');
        });

        $('#lvilles').on('click', 'font', function(e) {
            e.preventDefault();
            villes.splice(villes.indexOf($(this).attr('ville')),1);
            $('input[name="villes"]').val(villes);
            $(this).closest('li').remove();
        });
    }

    function load_upload() {
        $('#upload-zone').dmUploader({
            url: '/upload/image',
            dataType: 'json',
            allowedTypes: 'image/*',
            onBeforeUpload: function(id){
              $.danidemo.updateFileStatus(id, 'default', 'Téléchargement...');
            },
            onNewFile: function(id, file){
              $.danidemo.addFile('#files', id, file);
              /*** Begins Image preview loader ***/
              if (typeof FileReader !== "undefined"){        
                var reader = new FileReader();
                // Last image added
                var img = $('#files').find('.image-preview').eq(0);
                reader.onload = function (e) {
                  img.attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
              } else {
                // Hide/Remove all Images if FileReader isn't supported
                $('#files').find('.image-preview').remove();
              }
              /*** Ends Image preview loader ***/
            },
            onComplete: function(){},
            onUploadProgress: function(id, percent){
              var percentStr = percent + '%';
              $.danidemo.updateFileProgress(id, percentStr);
            },
            onUploadSuccess: function(id, data){
                if(data.status == 'ok') {
                    $.danidemo.updateFileStatus(id, 'success', data.msg);
                    $('#file' + id).find('a').attr('href', data.id);
                    $('#file' + id).attr('id', 'file_' + data.id);
                } else {
                    $.danidemo.updateFileStatus(id, 'error', data.msg);
                    $('#file' + id).delay(2000).fadeOut(500);
                }
                $.danidemo.updateFileProgress(id, '100%');
                $('.file a').click(function(e) {
                    e.preventDefault();
                    deleteImage($(this).attr('href'));
                });
            },
            onUploadError: function(id, message){
              $.danidemo.updateFileStatus(id, 'error', message);
              $('#file' + id).delay(2000).fadeOut(500);
            },
            onFileTypeError: function(file){
                notif(false, 'File \'' + file.name + '\' cannot be added: must be an image');
            },
            onFileSizeError: function(file){
                notif(false, 'File \'' + file.name + '\' cannot be added: size excess limit');
            },
            onFallbackMode: function(message){
                notif(false, 'Browser not supported(do something else here!): ' + message);
            }
        });

        $('.file a').click(function(e) {
            e.preventDefault();
            deleteImage($(this).attr('href'));
        });

        function deleteImage(id) {
            jQuery.ajax({
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                url: '{{ url() }}/delete/image'
            }).done(function (data) {
                if ( data.success == true ) {
                    $('#file_' + data.id).fadeOut(500);
                    notif(true,data.msg);
                } else {
                    notif(false,data.msg);
                }
            }).fail(function () {
                notif(false, 'Il y a eu un problème lors de la requête.');
            });
        }
    }

    load_presentation();
@endsection