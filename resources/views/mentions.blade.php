@extends('master')

@section('content')

@include('nav', ['fixed' => 'fixed'])

<div class="navtop fixed"></div>

<div class="content vh" style="background:url(../img/Background.png); text-align: justify;">
    <div class="wrapper register thintext">
		<span class="xltext center bold">MENTIONS LÉGALES</span>
		<br><br>
		Conformément aux dispositions de l’article 6 III-­‐I de la loi n° 2044-­‐575 du 21 juin 2004 pour la confiance dans l’économie numérique, le présent site est exploité par : Mayao, SAS au capital de 10000 Euros.
		<br><br>
		Siège Social : 93 rue du Chevaleret, 75013 PARIS RCS PARIS : 812 925 725 R.C.S
		Marque et logo : Mayao est une marque déposée et protégée. Hébergement : OVH
		<br><br>
		<span class="bold">Respect de la propriété intellectuelle</span>
		Toutes les marques, photographies, textes, commentaires, illustrations, images animées ou non, séquences vidéo, sons, ainsi que toutes les applications informatiques qui pourraient être utilisées pour faire fonctionner le Site et plus généralement tous les éléments reproduits ou utilisés sur le Site sont protégés par les lois en vigueur au titre de la propriété intellectuelle.
		<br><br>
		Ils sont la propriété pleine et entière de l'Editeur ou de ses partenaires, sauf mentions particulières. Toute reproduction, représentation, utilisation ou adaptation, sous quelque forme que ce soit, de tout ou partie de ces éléments, y compris les applications informatiques, sans l'accord préalable et écrit de l'Editeur, sont strictement interdites. Le fait pour l'Editeur de ne pas engager de procédure dès la prise de connaissance de ces utilisations non autorisées ne vaut pas acceptation desdites utilisations et renonciation aux poursuites.
		<br><br>
		Seule l'utilisation pour un usage privé dans un cercle de famille est autorisée et toute autre utilisation est constitutive de contrefaçon et/ou d'atteinte aux droits voisins, sanctionnées par Code de la propriété intellectuelle.
		<br><br>
		La reprise de tout ou partie de ce contenu nécessite l'autorisation préalable de l'Editeur ou du titulaire des droits sur ce contenu.
		<br><br>
		Liens hypertexte : "Des liens hypertextes contenus sur ce site peuvent renvoyer vers d'autres sites
		web ou d'autres sources Internet. Dans la mesure où la société MAYAO ne peut contrôler ces sites et
		ces sources externes, MAYAO ne peut être tenue pour responsable de la mise à disposition de ces
		sites et sources externes, et ne peut supporter aucune responsabilité quant aux contenus, plubicités,
		produits, services ou tout autre matériel disponibles sur ou à partir de ces sites ou sources externes".
		<br><br><br>
    </div>
</div>

<div class="navbottom fixed"></div>

@endsection