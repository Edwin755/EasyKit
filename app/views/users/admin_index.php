<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/users') ?>">Utilisateurs</a></li>
        <li class="item current">Liste des utilisateurs</li>
    </ul>
</div>
<h3 class="page_title">Liste des utilisateurs</h3>
<div class="page_content">
    <div class="row">
        <div class="col-9">
            <h4><?= $count ?> Utilisateurs</h4>
        </div>
        <div class="col-3">
            <a href="<?= HTML::link('admin1259/users/create') ?>" class="btn btn-primary right">Ajouter un utilisateur</a>
        </div>
    </div>
    <table class="table margtop">
        <thead>
            <tr>
                <th width="50">ID</th>
                <th width="50">Avatar</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>E-mail</th>
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user->users_id ?></td>
                <td><img src="<?= HTML::link('uploads/' . $user->media->medias_file) ?>" class="img-circle" alt="avatar" width="50"></td>
                <td><?= $user->users_lastname ?></td>
                <td><?= $user->users_firstname ?></td>
                <td><a href="mailto:<?= $user->users_email ?>"><?= $user->users_email ?></a></td>
                <td class="actions">
                    <a href=""><span class="fa fa-edit"></span></a>
                    <a href=""><span class="fa fa-key"></span></a>
                    <a href=""><span class="fa fa-ban"></span></a>
                    <a href=""><span class="fa fa-times"></span></a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>