@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Commandes</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
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
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection