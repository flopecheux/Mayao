<div class="center">MON MOODBOARD</div>

<div id="upload-zone" style="text-align:center; margin-top:10px;">
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
</div>
