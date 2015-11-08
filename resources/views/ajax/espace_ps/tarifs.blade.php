<div class="center">TARIFS</div>
<div class="border"></div>

{!! Form::open(array('url' => '/espace/tarifs/update', 'method' => 'post')) !!}
<table style="margin:0 auto;">
<tr>
 <td style="padding-right: 20px;">SHOPPING ACCOMPAGNÉ</td>
 <td>{!! Form::text('tarif_sa', $ps->tarif_sa, array('style' => 'width: 40px;')) !!} € / HEURE</td>
</tr>
<tr style="opacity:0.3;">
 <td>GESTION GARDE-ROBE</td>
 <td>{!! Form::text('tarif_sa', null, array('style' => 'width: 40px;', 'disabled')) !!} € / HEURE</td>
</tr>
<tr style="opacity:0.3;">
 <td>E-SHOPPING</td>
 <td>{!! Form::text('tarif_sa', null, array('style' => 'width: 40px;', 'disabled')) !!} € / HEURE</td>
</tr>
<tr style="opacity:0.3;">
 <td>SHOPPING À DISTANCE</td>
 <td>{!! Form::text('tarif_sa', null, array('style' => 'width: 40px;', 'disabled')) !!} € / HEURE</td>
</tr>
<tr style="opacity:0.3;">
 <td>SHOPPING EXPRESS</td>
 <td>{!! Form::text('tarif_sa', null, array('style' => 'width: 40px;', 'disabled')) !!} € / HEURE</td>
</tr>
</table>
<br><center><button class="button" type="submit">VALIDER</button></center>
{!! Form::close() !!}
