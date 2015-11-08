@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Commande n°{{ $commande->id }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Client
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="admin/user/{{ $commande->user->id }}" class="btn btn-xs btn-default"> Voir</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <b>{{ $commande->user->prenom.' '.$commande->user->nom }}</b><br>
                        {{ $commande->user->email }}<br>
                        {{ $commande->user->tel }}<br>
                        <i><small>MANGOPAY ID : {{ $commande->user->mangopay_id }}</small></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Personal shopper
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="admin/user/{{ $commande->userps->id }}" class="btn btn-xs btn-default"> Voir</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <b>{{ $commande->userps->prenom.' '.$commande->userps->nom }}</b><br>
                        {{ $commande->userps->email }}<br>
                        {{ $commande->userps->tel }}<br>
                        <i><small>MANGOPAY ID : {{ $commande->userps->mangopay_id }}</small></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Détails de la commande
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4>Service :</h4>
                            @if($commande->type == 'sa')
                            Personal shopping
                            @else
                            {{ $commande->type }}
                            @endif<br>
                            <h4>Date de prestation :</h4> 
                            {{ Carbon::createFromFormat('Y-m-d', $commande->date)->format('d/m/Y') }}<br>
                            <h4>Horaires :</h4>
                            <?php $horaires = explode(',', $commande->horaires); ?>
                            {{ $horaires[0] }}H à {{ end($horaires) + 1 }}H<br>
                            <h4>Payment ID :</h4>
                            {{ $commande->payment_id }}
                        </div>
                        <div class="col-md-6">
                            <h4>Date de création :</h4>
                            {{ Carbon::createFromFormat('Y-m-d H:i:s', $commande->created_at)->format('d/m/Y à H:i') }}
                            <h4>Tarif client :</h4> 
                            {{ $commande->tarif }}€<br>
                            <h4>Statut :</h4>
                            @if($commande->statut == 0)
                            <p class="text-muted">Commande créée</p>
                            @elseif($commande->statut == 1)
                            <p class="text-primary">Commande validée</p>
                            @elseif($commande->statut == 2)
                            <p class="text-danger">Commande annulée</p>
                            @elseif($commande->statut == 3)
                            <p class="text-success">Commande terminée</p>
                            (Reversement effectué)
                            @else
                            {{ $commande->statut }}
                            @endif
                        </div>
                    </div>
                </div>
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn-block btn-outline btn btn-danger btn-m"><i class="fa fa-history"></i> Modifier le statut de la commande</button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Modifier le statut de la commande</h4>
                            </div>
                            <div class="modal-body">
                            {!! Form::open(array('url' => 'admin/statut/'.$commande->id, 'method' => 'post', 'role' => 'form')) !!}
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            @if($commande->statut == 0)
                                            <input type="radio" name="statut" id="statut0" value="0" checked="checked">
                                            @else
                                            <input type="radio" name="statut" id="statut0" value="0">
                                            @endif
                                            <span class="text-muted">Commande créée</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            @if($commande->statut == 1)
                                            <input type="radio" name="statut" id="statut1" value="1" checked="checked">
                                            @else
                                            <input type="radio" name="statut" id="statut1" value="1">
                                            @endif
                                            <span class="text-primary">Commande validée</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            @if($commande->statut == 2)
                                            <input type="radio" name="statut" id="statut2" value="2" checked="checked">
                                            @else
                                            <input type="radio" name="statut" id="statut2" value="2">
                                            @endif
                                            <span class="text-danger">Commande annulée</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            @if($commande->statut == 3)
                                            <input type="radio" name="statut" id="statut3" value="3" checked="checked">
                                            @else
                                            <input type="radio" name="statut" id="statut3" value="3">
                                            @endif
                                            <span class="text-success">Commande terminée (payée)</span>
                                        </label>
                                    </div>
                                </div><br>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Modifier le statut</button>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endsection