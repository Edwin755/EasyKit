<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/users') ?>">Accès API</a></li>
        <li class="item current">Liste des accès API</li>
    </ul>
</div>
<h3 class="page_title">Accès API</h3>
<div class="page_content">
    <table class="table">
        <thead>
            <tr>
                <th>Controller</th>
                <th>Nom</th>
                <th>Method</th>
                <th>Paramètres</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="6"><strong>Users</strong></td>
            </tr>
            <tr>
                <td>Créer utilisateur</td>
                <td>POST</td>
                <td>
                    <div>
                        <span class="fa fa-key"></span> email
                    </div>
                    <div>
                        <span class="fa fa-key"></span> password
                    </div>
                    <div>
                        firstname
                    </div>
                    <div>
                        lastname
                    </div>
                    <div>
                        birth (2015-12-31 23:59:59)
                    </div>
                </td>
                <td><a href="<?= HTML::link('api/users/create') ?>"><?= HTML::link('api/users/create') ?></a></td>
            </tr>
            <tr>
                <td>Authentification utilisateur</td>
                <td>POST</td>
                <td>
                    <div>
                        <span class="fa fa-key"></span> email
                    </div>
                    <div>
                        <span class="fa fa-key"></span> password
                    </div>
                </td>
                <td><a href="<?= HTML::link('api/users/auth') ?>"><?= HTML::link('api/users/auth') ?></a></td>
            </tr>
            <tr>
                <td>Authentification utilisateur: token existant</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/users/auth/' . $token) ?>"><?= HTML::link('api/users/auth/' . $token) ?></a></td>
            </tr>
            <tr>
                <td>Liste utilisateurs (20)</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/users') ?>"><?= HTML::link('api/users') ?></a></td>
            </tr>
            <tr>
                <td>Utilisateurs spécifique par ID</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/users/get/1') ?>"><?= HTML::link('api/users/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Events</strong></td>
            </tr>
            <tr>
                <td>Créer événement</td>
                <td>POST</td>
                <td>
                    <div>
                        <span class="fa fa-key"></span> name
                    </div>
                    <div>
                        <span class="fa fa-key"></span> starttime
                    </div>
                    <div>
                        <span class="fa fa-key"></span> endtime
                    </div>
                    <div>
                        description
                    </div>
                    <div>
                        token
                    </div>
                </td>
                <td><a href="<?= HTML::link('api/events/create') ?>"><?= HTML::link('api/events/create') ?></a></td>
            </tr>
            <tr>
                <td>Liste événements (20)</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/events') ?>"><?= HTML::link('api/events') ?></a></td>
            </tr>
            <tr>
                <td>Evénement spécifique par ID</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/events/get/1') ?>"><?= HTML::link('api/events/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Packs</strong></td>
            </tr>
            <tr>
                <td>Créer pack</td>
                <td>POST</td>
                <td>
                    <div>
                        <span class="fa fa-key"></span> name
                    </div>
                    <div>
                        <span class="fa fa-key"></span> end
                    </div>
                    <div>
                        <span class="fa fa-key"></span> token
                    </div>
                    <div>description</div>
                </td>
                <td><a href="<?= HTML::link('api/packs/create') ?>"><?= HTML::link('api/packs/create') ?></a></td>
            </tr>
            <tr>
                <td>Liste packs (20)</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/packs') ?>"><?= HTML::link('api/packs') ?></a></td>
            </tr>
            <tr>
                <td>Pack spécifique par ID</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/packs/get/1') ?>"><?= HTML::link('api/packs/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Medias</strong></td>
            </tr>
            <tr>
                <td>Envoyer un média</td>
                <td>POST</td>
                <td>
                    <div>
                        /inset
                    </div>
                </td>
                <td><a href="<?= HTML::link('api/medias/send') ?>"><?= HTML::link('api/medias/send') ?></a></td>
            </tr>
            <tr>
                <td>Liste médias (20)</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/medias') ?>"><?= HTML::link('api/medias') ?></a></td>
            </tr>
            <tr>
                <td>Média spécifique par ID</td>
                <td>GET</td>
                <td></td>
                <td><a href="<?= HTML::link('api/medias/get/1') ?>"><?= HTML::link('api/medias/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="2"><strong>Steps</strong></td>
            </tr>
            <tr>
                <td>Créer étape</td>
                <td>POST</td>
                <td>
                    <div>
                        <span class="fa fa-key"></span> name
                    </div>
                    <div>
                        <span class="fa fa-key"></span> goal
                    </div>
                    <div>
                        <span class="fa fa-key"></span> pack
                    </div>
                    <div>
                        <span class="fa fa-key"></span> token
                    </div>
                </td>
                <td><a href="<?= HTML::link('api/steps/create') ?>"><?= HTML::link('api/steps/create') ?></a></td>
            </tr>
        </tbody>
    </table>
</div>