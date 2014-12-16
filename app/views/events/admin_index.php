<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/users') ?>">Événements</a></li>
        <li class="item current">Liste des événements</li>
    </ul>
</div>
<h3 class="page_title">Liste des événements</h3>
<div class="page_content">
    <div class="row">
        <div class="col-9">
            <h4><?= $count ?> Événement<?= $count != 1 ? 's' : '' ?></h4>
        </div>
        <div class="col-3">
            <a href="<?= HTML::link('admin1259/users/create') ?>" class="btn btn-primary right">Ajouter un événement</a>
        </div>
    </div>
    <table class="table margtop">
        <thead>
            <tr>
                <th width="50">ID</th>
                <th>Nom</th>
                <th>Créateur</th>
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody id="list">
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $event->events_id ?></td>
                    <td><?= $event->events_name ?></td>
                    <td><a href="mailto:<?= $event->user->users_email ?>"><?= $event->user->users_firstname ?> <?= $event->user->users_lastname ?></a></td>
                    <td></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<script src="<?= HTML::link('admin/scripts/mustache.js') ?>"></script>