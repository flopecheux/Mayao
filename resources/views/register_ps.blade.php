@extends('master', ['title' => 'Devenez personal shopper sur MAYAO', 'meta' => 'Inscrivez-vous en tant que personal shopper sur mayao.fr'])

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content espace hv">
    <div class="wrapper center register">
		<span class="xltext">
			@if(Session::has('ps'))
			{{ trans('global.step') }} 2 : 
			@endif
			{{ trans('global.register_ps') }}
		</span>
		<img scr="./img/Forme-5.png">
        {!! Form::open(array('url' => '/register/ps', 'method' => 'post', 'files'=>true)) !!}
        	<span class="mtext">{{ trans('global.pitch_r') }} <font color="red"><big>*</big></font></span>
	        {!! Form::textarea('pitch', old('pitch'), array('placeholder' => trans('global.pitch_p_r'))) !!}<br>
	        <span class="mtext">{{ trans('global.marques_f') }} <font color="red"><big>*</big></font></span>
	     	<div class="marques">
                <ul>
                @foreach($marques as $marque)
                    <li>
                    	{!! Form::checkbox('marques[]', $marque->id, (Input::old('marques[]') ==  $marque->id), ['id' => $marque->id]) !!}
                    	<label for="{{ $marque->id }}">{{ $marque->nom }}</label>
                    </li>
                @endforeach
                </ul>
            </div><br>
            <span class="mtext">{{ trans('global.icones_r') }} <font color="red"><big>*</big></font></span>
            {!! Form::text('icones', old('icones'), array('placeholder' => trans('global.icones_mode'))) !!}
            <span class="mtext">{{ trans('global.photo_r') }} <font color="red"><big>*</big></font></span>
	        {!! Form::file('photo') !!}<br>
			<span class="mtext">{{ trans('global.images_r') }} <font color="red"><big>*</big></font></span>
			
			<div id="upload-zone">
				<span>Déposez ici vos images pour illustrer votre moodboard<br><br>OU<br><br></span>
				<div class="btn-input button flat">
					Sélectionnez un fichier
					<input type="file" name="files[]" accept="image/*" multiple="multiple" title="Click to add Images">
				</div>
			</div>

			<div id="files" file-counter="{{ $photos->count() }}">
				@foreach($photos as $photo)
				<div id="file_{{ $photo->id }}" class="file">
					<img src="{{ $photo->url }}">
					<a href="{{ $photo->id }}">X</a>{{ $photo->description }}
					<div class="clear"></div>
				</div>
				@endforeach
			</div><br>

			<span class="mtext">{{ trans('global.cv_r') }}</span>
	        {!! Form::file('cv') !!}
	        <span class="mtext">{{ trans('global.activite_r') }} <font color="red"><big>*</big></font></span>
            {!! Form::text('activite', old('activite'), array('placeholder' => trans('global.activite_p_r'))) !!}
            <span class="mtext">{{ trans('global.motivation_r') }} <font color="red"><big>*</big></font></span>
            {!! Form::textarea('motivation', old('motivation'), array('placeholder' => trans('global.motivation_p_r'))) !!}
            <span class="mtext">{{ trans('global.tarif_sa_r') }} <font color="red"><big>*</big></font>
            <br><small>MAYAO prélève une commission de 10% HT au moment où vous recevez votre paiement.</small></span>
            {!! Form::text('tarif_sa', old('tarif_sa'), array('placeholder' => trans('global.tarif_sa_p_r'))) !!}
            <span class="mtext">{{ trans('global.specialite_r') }} <font color="red"><big>*</big></font></span>
            {!! Form::checkbox('specialite[]', 'H', (Input::old('specialite') == 'H' || Input::old('specialite') == 'HF'), ['id' => 'h']) !!}
            <label for="h">HOMME</label>
            {!! Form::checkbox('specialite[]', 'F', (Input::old('specialite') == 'F' || Input::old('specialite') == 'HF'), ['id' => 'f']) !!}
            <label for="f">FEMME</label><br><br>
            <span class="mtext">Renseignez vos informations bancaires <font color="red"><big>*</big></font></span>
            {!! Form::text('iban', old('iban'), array('placeholder' => 'IBAN')) !!}
            {!! Form::text('bic', old('bic'), array('placeholder' => 'BIC')) !!}
            <span class="mtext">{{ trans('global.villes_r') }} <font color="red"><big>*</big></font></span>
            <ul id="lvilles" style="padding-bottom: 10px; margin-top: -10px;"></ul>
            {!! Form::hidden('villes', old('villes')) !!}
            {!! Form::text(null, null, array('id' => 'address', 'placeholder' => trans('global.villes_p_r'))) !!}
            {!! Form::checkbox('charte', 1, (Input::old('charte') == 1), ['id' => 'c']) !!}
            <label for="c">J’adhère à la <a href="{{ url() }}#charter" style="color: black !important;" target="_bank"><u>charte éthique</u></a> <font color="red"><big>*</big></font></label><br><br>
	        <button class="button" type="submit">{{ trans('global.validate_register') }}</button><br><br><br>
        {!! Form::close() !!}
    </div>
</div>

<div class="navbottom fixed"></div>
@endsection

@section('includejs')
<script type="text/javascript" src="js/dmuploader.js"></script>
<script type="text/javascript" src="js/preview.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script type="text/javascript" src="js/typeahead.bundle.js"></script>
<script type="text/javascript" src="js/typeahead-addresspicker.js"></script>
@endsection

@section('customjs')
    $( "#date" ).datepicker();

    $('.marques').slimScroll({
        height: '110px',
        railVisible: true
    });

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
@endsection