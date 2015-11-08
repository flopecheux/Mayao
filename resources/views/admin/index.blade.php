@extends('admin.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tableau de bord</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $count_commandes }}</div>
                                    <div>Commandes</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/commandes">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les commandes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $count_users }}</div>
                                    <div>Clients</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/users">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les clients</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-star fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $count_ps }}</div>
                                    <div>Personal shoppers</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/ps">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les personal shoppers</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endsection