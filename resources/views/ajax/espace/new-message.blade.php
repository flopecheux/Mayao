<div class="center">CRÉER UN MESSAGE</div>
<div class="border" style="margin-bottom:15px;"></div>

{!! Form::open(array('url' => '/espace/message/new', 'method' => 'post')) !!}
    <select type="text" id="user" name="user" style="width: calc(100% - 32px);">
        <option value="" disabled selected>SÉLECTIONNEZ UN DESTINATAIRE</option>
        @foreach($users as $user)
        <option value="{{ $user->id }}">{{ mb_strtoupper($user->prenom.' '.$user->nom) }}</option>
        @endforeach
    </select>
    <br><br>
    {!! Form::textarea('message', old('message'), array('placeholder' => 'VOTRE MESSAGE', 'style' => 'border-radius: 5px !important; margin:0; width: calc(100% - 22px);')) !!}<br><br>
    <button class="button" type="submit">ENVOYER</button><br><br>
{!! Form::close() !!}