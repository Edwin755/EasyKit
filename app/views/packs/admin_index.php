<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/packs') ?>">Packs</a></li>
        <li class="item current">Liste des packs</li>
    </ul>
</div>
<h3 class="page_title">Liste des packs</h3>
<div class="page_content">
    <div class="row">
        <div class="col-9">
            <h4><?= $count ?> Pack<?= $count != 1 ? 's' : '' ?></h4>
        </div>
        <div class="col-3">
            <div class="form-control">
                <input class="input" id="search" type="search" placeholder="Rechercher">
            </div>
        </div>
    </div>
    <div class="row margtop" id="loading">
        <div class="col-12">
            <div class="panel loading">
                <div class="user">
                    <div class="img-circle" style="width: 45px; height: 45px;"></div>
                    <span class="name">Name</span>
                    <p><?= date('F j') ?> at <?= date('H:i') ?></p>
                </div>
                <div class="panel-content">
                    <p>A créé le pack "hello world".</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row margtop template" ng-app="Packs">
        <div class="col-12" ng-controller="PacksController">
            <div class="panel" ng-repeat="pack in packs">
                <div class="user">
                    <img class="img-circle" src="{{pack.user.users_media.medias_file}}" width="45" alt="">
                    <span class="name"><a href="">{{pack.user.users_firstname}} {{pack.user.users_lastname}}</a></span>
                    <p>{{pack.timeago}}</p>
                </div>
                <div class="panel-content">
                    <p>A créé le pack "<a href="">{{pack.packs_name}}</a>".</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= HTML::link('admin/scripts/angular.min.js') ?>"></script>
<script>
    var app = angular.module('Packs', []);

    app.controller('PacksController', function ($scope, $http) {
        $http.get('<?= HTML::link('api/packs') ?>')
            .success(function (data, status, headers, config) {
                $('#loading').remove();
                $('.template').removeClass('template');
                $scope.packs = data.packs;
            })
            .error(function (data, status, headers, config) {

            });
    });
</script>
