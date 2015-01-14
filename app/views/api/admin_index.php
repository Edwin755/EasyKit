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
                <td><a href="<?= HTML::link('api/users/create') ?>"><?= HTML::link('api/users/create') ?></a></td>
            </tr>
            <tr>
                <td>Authentification utilisateur</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/users/auth') ?>"><?= HTML::link('api/users/auth') ?></a></td>
            </tr>
            <tr>
                <td>Authentification utilisateur: token existant</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/users/auth/' . $token) ?>"><?= HTML::link('api/users/auth/' . $token) ?></a></td>
            </tr>
            <tr>
                <td>Liste utilisateurs (20)</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/users') ?>"><?= HTML::link('api/users') ?></a></td>
            </tr>
            <tr>
                <td>Utilisateurs spécifique par ID</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/users/get/1') ?>"><?= HTML::link('api/users/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="3"><strong>Events</strong></td>
            </tr>
            <tr>
                <td>Liste événements (20)</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/events') ?>"><?= HTML::link('api/events') ?></a></td>
            </tr>
            <tr>
                <td>Evénement spécifique par ID</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/events/get/1') ?>"><?= HTML::link('api/events/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Packs</strong></td>
            </tr>
            <tr>
                <td>Créer pack</td>
                <td>POST</td>
                <td><a href="<?= HTML::link('api/packs/create') ?>"><?= HTML::link('api/packs/create') ?></a></td>
            </tr>
            <tr>
                <td>Liste packs (20)</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/packs') ?>"><?= HTML::link('api/packs') ?></a></td>
            </tr>
            <tr>
                <td>Pack spécifique par ID</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/packs/get/1') ?>"><?= HTML::link('api/packs/get/1') ?></a></td>
            </tr>
            <tr>
                <td rowspan="5"><strong>Medias</strong></td>
            </tr>
            <tr>
                <td>Envoyer un média (Redimensionnement Outbound par défaut)</td>
                <td>POST</td>
                <td><a href="<?= HTML::link('api/medias/send') ?>"><?= HTML::link('api/medias/send') ?></a></td>
            </tr>
            <tr>
                <td>Envoyer un média (Redimensionnement Inset)</td>
                <td>POST</td>
                <td><a href="<?= HTML::link('api/medias/send/inset') ?>"><?= HTML::link('api/medias/send/inset') ?></a></td>
            </tr>
            <tr>
                <td>Liste médias (20)</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/medias') ?>"><?= HTML::link('api/medias') ?></a></td>
            </tr>
            <tr>
                <td>Média spécifique par ID</td>
                <td>GET</td>
                <td><a href="<?= HTML::link('api/medias/get/1') ?>"><?= HTML::link('api/medias/get/1') ?></a></td>
            </tr>
        </tbody>
    </table>
</div>