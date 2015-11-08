<div class="center">PRÉSENTATION</div>
<div class="border" style="margin-bottom:15px;"></div>

{!! Form::open(array('url' => '/espace/presentation/update', 'method' => 'post')) !!}
    <span class="smtext">{{ trans('global.pitch_r') }}</span>
    {!! Form::textarea('pitch', $ps->pitch, array('placeholder' => trans('global.pitch_p_r'))) !!}<br>
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
    {!! Form::text('icones', $ps->icones, array('placeholder' => trans('global.icones_mode'))) !!}<br>
    <span class="smtext">{{ trans('global.villes_r') }}</span>
    <ul id="lvilles" style="padding-bottom: 10px; margin-top: 0px;"></ul>
    {!! Form::hidden('villes', $ps->villes) !!}
    {!! Form::text(null, null, array('id' => 'address', 'placeholder' => trans('global.villes_p_r'))) !!}
    <span class="smtext">Choisissez une ou plusieurs catégories</span>
    {!! Form::checkbox('specialite[]', 'H', ($ps->specialite == 'H' || $ps->specialite == 'HF'), ['id' => 'h']) !!}
    <label for="h">HOMME</label>
    {!! Form::checkbox('specialite[]', 'F', ($ps->specialite == 'F' || $ps->specialite == 'HF'), ['id' => 'f']) !!}
    <label for="f">FEMME</label><br>
    <button class="button" type="submit">VALIDER MES MODIFICATIONS</button><br><br>
{!! Form::close() !!}