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
        <div class="col-3"></div>
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
        <tbody>
        <?php foreach ($packs as $pack) : ?>
            <tr>
                <td><?= $pack->packs_id ?></td>
                <td><?= $pack->packs_name ?></td>
                <td><?= $pack->user->users_firstname ?> <?= $pack->user->users_lastname ?></td>
                <td class="actions">
                    <a href=""><span class="fa fa-edit"></span></a>
                    <a href=""><span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>