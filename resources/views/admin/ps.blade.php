@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Personal shoppers</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Personal shopper</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ps as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->prenom.' '.$user->nom }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->tel }}</td>
                            <td><a href="admin/user/{{ $user->id }}" class="btn-block btn btn-primary btn-xs">Voir</a></td>
                            <td><a href="admin/userlogin/{{ $user->id }}" target="_blank" class="btn-block btn btn-success btn-xs"><i class="fa fa-user"></i> Connexion</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $ps->render() !!}
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection