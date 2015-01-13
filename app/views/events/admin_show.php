<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/events') ?>">Événements</a></li>
        <li class="item current">Affichage d'un événement</li>
    </ul>
</div>
<h3 class="page_title">Affichage d'un événement</h3>
<div class="page_content">
    <div class="row">
        <?php foreach ($event->events_medias as $media) : ?>
            <div class="card">
                <div class="image">
                    <ul class="slides" data-slide data-delay="<?= rand(3500, 5000) ?>">
                        <li class="item" style="background-image: url(<?= HTML::link('uploads/' . $media->medias_file) ?>);"></li>
                    </ul>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="row margtop">
        <div class="col-6">
            <h2><?= $event->events_name ?></h2>
            <p><?= $event->events_description ?></p>
        </div>
        <div class="col-6">
            <div class="user">
                <div class="informations">
                    <div class="name"><?= $event->user->users_firstname ?> <?= $event->user->users_lastname ?></div>
                    <div class="complement">Inscrit le <?= date('j M Y', strtotime($event->user->users_created_at)) . ' à ' . date('G:i:s', strtotime($event->user->users_created_at)) ?></div>
                </div>
                <div class="image">
                    <img class="img-circle" src="<?= $event->user->users_media->medias_file ?>" alt="">
                </div>
            </div>
            <div class="text-right addon">
                <?= $event->events_geox ?>, <?= $event->events_geoy ?><span class="fa fa-map-marker"></span>
            </div>
            <div class="text-right addon">
                Du <strong><?= date('j M Y', strtotime($event->events_starttime)) ?></strong> au <strong><?= date('j M Y', strtotime($event->events_endtime)) ?></strong><span class="fa fa-calendar"></span>
            </div>
            <div class="text-right addon">
                <strong>215</strong> participants <span class="fa fa-users"></span>
            </div>
        </div>
    </div>
</div>