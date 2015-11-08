@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">#{{ $user->id }} - {{ $user->prenom.' '.$user->nom }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Informations personnelles
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4>Email :</h4>
                            {{ $user->email }}<br>
                            <h4>Téléphone :</h4> 
                            {{ $user->tel }}
                            <h4>Inscrit le :</h4>
                            {{ Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d/m/Y à H:i') }}<br>
                            <br><i><small>MANGOPAY ID : {{ $user->mangopay_id }}</small></i>
                        </div>
                        <div class="col-md-6">
                            <h4>Adresse:</h4>
                            {{ $user->adresse.', '.$user->codepostal.' '.$user->ville }}<br>
                            <h4>Date de naissance :</h4> 
                            {{ Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y') }}<br>
                            <h4>Sexe :</h4>
                            @if($user->sexe == 'H')
                            Homme
                            @else
                            Femme
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($user->checkps)
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Informations personal shopper
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4>Activité(s) :</h4>
                            {{ $user->ps->activite }}<br>
                            <h4>Motivation(s) :</h4> 
                            {{ $user->ps->motivation }}
                        </div>
                        <div class="col-md-6">
                            <h4>Spécialité(s) :</h4>
                            @if($user->ps->specialite == 'H')
                            {{ trans('global.man') }}
                            @elseif($user->ps->specialite == 'F')
                            {{ trans('global.woman') }}
                            @else
                            {{ trans('global.man') }} & {{ trans('global.woman') }}
                            @endif
                            <h4>CV :</h4>
                            @if(!empty($user->ps->cv))
                            <a href="{{ url('uploads/cv').'/'.$user->ps->cv }}" target="_blank">Télécharger</a>
                            @else
                            Non renseigné
                            @endif
                        </div>
                    </div>
                </div>
                @if($user->ps->active == 1)
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn-block btn-outline btn btn-warning btn-m"><i class="fa fa-lock"></i> Bloquer le personal shopper</button>
                @else
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn-block btn-outline btn btn-info btn-m"><i class="fa fa-unlock"></i> Débloquer le personal shopper</button>
                @endif
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Confirmez-vous l'action ?</h4>
                            </div>
                            <div class="modal-body">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <a href="admin/active/{{ $user->id }}" class="btn btn-primary">Confirmer l'action</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            @endif

            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Commandes
                    </div>
                    <div class="panel-body">
                        @if($commandes->count() > 0)
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Personal shopper</th>
                                    <th>Date prestation</th>
                                    <th>Statut</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->id }}</td>
                                    <td>{{ $commande->user->prenom.' '.$commande->user->nom }}</td>
                                    <td>{{ $commande->userps->prenom.' '.$commande->userps->nom }}</td>
                                    <td>{{ Carbon::createFromFormat('Y-m-d', $commande->date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($commande->statut == 0)
                                        <span class="text-muted">Commande créée</span>
                                        @elseif($commande->statut == 1)
                                        <span class="text-primary">Commande validée</span>
                                        @elseif($commande->statut == 2)
                                        <span class="text-danger">Commande annulée</span>
                                        @elseif($commande->statut == 3)
                                        <span class="text-success">Commande terminée</span>
                                        @else
                                        {{ $commande->statut }}
                                        @endif
                                    </td>
                                    <td><a href="admin/commande/{{ $commande->id }}" class="btn btn-block btn-primary btn-xs">Voir la commande</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $commandes->render() !!}
                        @else
                        Aucune commande
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
@endsection