<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/events') ?>">Événements</a></li>
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
            <a href="<?= HTML::link('admin1259/events/create') ?>" class="btn btn-primary right">Ajouter un événement</a>
        </div>
    </div>
    <div class="rowcards">
        <?php foreach ($events as $event): ?>
            <div class="card">
                <div class="image">
                    <ul class="slides" data-slide data-delay="<?= rand(3500, 5000) ?>">
                        <?php foreach ($event->events_medias as $media): ?>
                            <li class="item" style="background-image: url(<?= $media->medias_file ?>);"></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="informations">
                    <div class="name"><?= $event->events_name ?></div>
                    <div class="complement"><span class="fa fa-calendar"></span>Du <strong><?= date('j M Y', strtotime($event->events_starttime)) ?></strong> au <strong><?= date('j M Y', strtotime($event->events_endtime)) ?></strong></div>
                    <div class="options">
                        <a href="#" data-toggle><span class="fa fa-ellipsis-v"></span></a>
                        <ul class="menu">
                            <li class="item"><a href="<?= HTML::link('admin1259/events/show/' . $event->events_id) ?>">Voir</a></li>
                            <li class="item"><a href="<?= HTML::link('admin1259/events/edit/' . $event->events_id) ?>">Modifier</a></li>
                            <li class="item"><a href="<?= HTML::link('admin1259/events/delete/' . $event->events_id) ?>">Supprimer</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<script src="<?= HTML::link('admin/scripts/slides.js') ?>"></script>