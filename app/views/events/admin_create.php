<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/events') ?>">Événements</a></li>
        <li class="item current">Création d'un événement</li>
    </ul>
</div>
<h3 class="page_title">Création d'un événement</h3>
<div class="page_content">
    <div class="row">
        <div class="col-6">
            <form action="<?= HTML::link('admin1259/events/store') ?>" method="post">
                <div class="form-control inline">
                    <label for="name">Nom<span class="required">*</span></label>
                    <input class="input" id="name" name="name" type="text" placeholder="Nom" required autofocus>
                </div>
                <div class="form-control inline">
                    <label for="description">Déscription<span class="required">*</span></label>
                    <textarea class="input" id="description" name="description" placeholder="Déscription" required></textarea>
                </div>
                <div class="form-control inline">
                    <label for="start">Date de début<span class="required">*</span></label>
                    <input class="input" id="start" name="start" type="date" required>
                </div>
                <div class="form-control inline">
                    <label for="end">Date de fin<span class="required">*</span></label>
                    <input class="input" id="end" name="end" type="date" required>
                </div>
                <div class="form-control">
                    <button class="btn btn-primary" id="send">Ajouter</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <div class="top-panel">
                <div class="dropzone">
                    <span class="text">Déposez vos fichiers ici.</span>
                </div>
                <div class="details">
                    <button class="btn btn-success">Test</button>
                </div>
            </div>
        </div>
    </div>
</div>