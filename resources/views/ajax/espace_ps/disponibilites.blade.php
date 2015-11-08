<div class="center">DISPONIBILITÉS</div>
<div class="border" style="margin-bottom:15px;"></div>

{!! Form::open(array('url' => '/espace/disponibilites/update', 'method' => 'post')) !!}
	<span class="smtext">MES DISPONIBILITÉS RÉCURRENTES</span>

	<div id="accordion" class="rec">
	  <h3>Lundi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Monday"]))
		<input type="checkbox" value="{{ $i }}" id="mon-{{ $i }}" name="mon[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="mon-{{ $i }}" name="mon[]"/>
		@endif 
		<label for="mon-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Mardi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Tuesday"]))
		<input type="checkbox" value="{{ $i }}" id="tue-{{ $i }}" name="tue[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="tue-{{ $i }}" name="tue[]"/>
		@endif
		<label for="tue-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Mercredi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Wednesday"]))
		<input type="checkbox" value="{{ $i }}" id="wed-{{ $i }}" name="wed[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="wed-{{ $i }}" name="wed[]"/>
		@endif
		<label for="wed-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Jeudi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Thursday"]))
		<input type="checkbox" value="{{ $i }}" id="thu-{{ $i }}" name="thu[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="thu-{{ $i }}" name="thu[]"/>
		@endif
		<label for="thu-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Vendredi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Friday"]))
		<input type="checkbox" value="{{ $i }}" id="fri-{{ $i }}" name="fri[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="fri-{{ $i }}" name="fri[]"/>
		@endif
		<label for="fri-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Samedi</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Saturday"]))
		<input type="checkbox" value="{{ $i }}" id="sat-{{ $i }}" name="sat[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="sat-{{ $i }}" name="sat[]"/>
		@endif
		<label for="sat-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	  <h3>Dimanche</h3>
	  <div>
	  @for($i = 8; $i < 23; $i++)
	  	@if(in_array($i, $horaires["Sunday"]))
		<input type="checkbox" value="{{ $i }}" id="sun-{{ $i }}" name="sun[]" checked="checked" />
		@else
		<input type="checkbox" value="{{ $i }}" id="sun-{{ $i }}" name="sun[]"/>
		@endif
		<label for="sun-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
	  @endfor
	  </div>
	</div>
	<br>
	<button class="button" type="submit">VALIDER MES MODIFICATIONS</button><br><br>
{!! Form::close() !!}

{!! Form::open(array('url' => '/espace/indisp/add', 'method' => 'post')) !!}
	<br><span class="smtext">MES INDISPONIBILITÉS EXCEPTIONNELLES</span>
	
	@foreach($indisp as $ind)
		<div class="bindisp">
		<?php $horaires = explode(',', $ind->horaires); ?>
		{{ Carbon::createFromFormat('Y-m-d', $ind->date)->format('d/m/y') }}
		<small class="thintext">
		@foreach($horaires as $key => $h)
		@if($key != 0)/@endif
		{{ $h }}H
		@endforeach
		</small>
		(<font color="red" class="indisp" style="cursor:pointer;" id="{{ $ind->id }}">X</font>)
		</div>
	@endforeach

	<br><div id="accordion" class="indisp">
		<h3>Ajouter une indisponibilité</h3>
		<div>
			<input type="text" name="indisp_date" id="indisp_date" placeholder="Date" style="width: calc(100% - 55px); margin: 10px;">
			<input type="checkbox" id="checkAll">
			<label for="checkAll">Tout cocher</label>
		  	@for($i = 8; $i < 23; $i++)
			<input type="checkbox" value="{{ $i }}" id="indisp-{{ $i }}" name="indisp[]" />
			<label for="indisp-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
		  	@endfor
		  	<br><button class="button" type="submit" style="margin-left:15px; margin-bottom:15px;">AJOUTER</button>
		</div>
	</div>
{!! Form::close() !!}

{!! Form::open(array('url' => '/espace/disp/add', 'method' => 'post')) !!}
	<br><span class="smtext">MES DISPONIBILITÉS EXCEPTIONNELLES</span>

	@foreach($disp as $dis)
		<div class="bdisp">
		<?php $horaires = explode(',', $dis->horaires); ?>
		{{ Carbon::createFromFormat('Y-m-d', $dis->date)->format('d/m/y') }}
		<small class="thintext">
		@foreach($horaires as $key => $h)
		@if($key != 0)/@endif
		{{ $h }}H
		@endforeach
		</small>
		(<font class="disp" color="red" style="cursor:pointer;" id="{{ $dis->id }}">X</font>)
		</div>
	@endforeach

	<br><div id="accordion" class="disp">
		<h3>Ajouter une disponibilité</h3>
		<div>
			<input type="text" name="disp_date" id="disp_date" placeholder="Date" style="width: calc(100% - 55px); margin: 10px;">
			<input type="checkbox" id="checkAll2">
			<label for="checkAll2">Tout cocher</label>
		  	@for($i = 8; $i < 23; $i++)
			<input type="checkbox" value="{{ $i }}" id="disp-{{ $i }}" name="disp[]" />
			<label for="disp-{{ $i }}">{{ $i }}H - {{ $i+1 }}H</label>
		  	@endfor
		  	<br><button class="button" type="submit" style="margin-left:15px; margin-bottom:15px;">AJOUTER</button>
		</div>
	</div>
{!! Form::close() !!}

<script type="text/javascript">
$('.rec, .indisp, .disp').accordion({
    active: true,
    collapsible: true,
    heightStyle: "content"
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

$("#indisp_date, #disp_date").datepicker({
    dateFormat: "dd-mm-yy"
});

$('#checkAll').click(function () {    
	$('input[name="indisp[]"]').prop('checked', this.checked);    
});

$('#checkAll2').click(function () {    
	$('input[name="disp[]"]').prop('checked', this.checked);    
});

function notif(success, msg) {
    $(".notif").remove();
    if (success == true) {
        $("body").append('<div class="notif success">' + msg + '</div>');
    } else {
        $("body").append('<div class="notif error">' + msg + '</div>');
    }
    $(".notif").slideDown(500).delay(2000).fadeOut(500);
}

$('font.disp, font.indisp').click(function(e) {
    e.preventDefault();
    var font = $(this);
    jQuery.ajax({
        type: 'GET',
        dataType: 'json',
        url: '{{ url('/espace/dispo/delete') }}' + '/' + font.attr('id')
    }).done(function (data) {
        font.closest('div.bdisp, div.bindisp').remove();
        notif(true, data.msg);
    }).fail(function () {
        notif(false, 'Il y a eu un problème lors de la requête.');
    });
});
</script>