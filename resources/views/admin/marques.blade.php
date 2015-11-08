@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Marques</h1>
                {!! Form::open(array('url' => '/admin/marqueadd', 'method' => 'post', 'role' => 'form')) !!}
                    <div class="form-group">
                        <label>Ajouter une marque</label>
                        <input class="form-control" name="marque">    
                    </div>
                    <button type="submit" class="btn btn-default">Ajouter la marque</button>
                {!! Form::close() !!}<br>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($marques as $marque)
                        <tr>
                            <td>{{ $marque->id }}</td>
                            <td>{{ $marque->nom }}</td>
                            <td><a href="admin/marquedelete/{{ $marque->id }}" class="btn btn-block btn-danger btn-xs">Supprimer</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $marques->render() !!}
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection