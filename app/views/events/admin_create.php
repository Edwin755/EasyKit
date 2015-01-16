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
            <div class="top-panel" id="uploader">
                <div id="dropzone" class="dropzone">
                    <div class="text">
                        <p>Déposez vos fichiers ici.</p>
                        <span class="or">ou</span>
                        <a id="browse" href="#">Parcourir</a>
                    </div>
                </div>
                <div class="details">
                    <div class="rowcards" id="template">
                        <div class="card" id="{{id}}">
                            <div class="image">
                                <ul class="slides">
                                    <li class="item" style="background-image: url({{name}});"></li>
                                </ul>
                                <div class="progress">
                                    <div class="bar"></div>
                                </div>
                            </div>
                            <div class="informations">
                                <div class="complement">{{size}}</div>
                                <div class="options">
                                    <a href="#"><span class="fa fa-trash"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= HTML::link('admin/scripts/mustache.js') ?>"></script>
<script src="<?= HTML::link('admin/scripts/plupload/moxie.min.js') ?>"></script>
<script src="<?= HTML::link('admin/scripts/plupload/plupload.min.js') ?>"></script>
<script>
    var template = $('#template').html();
    $('#template').children().remove();
    var uploader = new plupload.Uploader({
        runtimes        : 'html5',
        container       : 'uploader',
        drop_element    : 'dropzone',
        browse_button   : 'browse',
        url             : '<?= HTML::link('api/medias/send'); ?>',
        multipart       : true,
        urlstream_upload: true,
        filters: [
            {title: 'Images', extensions: 'jpeg,jpg,gif,png'}
        ]
    });

    uploader.init();

    uploader.bind('FilesAdded', function (up, files) {
        var filelist = $('.rowcards');
        for (var i in files) {
            var file = files[i];
            file.size = plupload.formatSize(file.size);
            filelist.append(Mustache.render(template, file));
        }

        $('#dropzone').removeClass('hover');
        uploader.start();
        uploader.refresh();
    });

    uploader.bind('Error', function (up, error) {
        alert(error.message);
        uploader.refresh();

        $('#dropzone').removeClass('hover');
    });

    uploader.bind('UploadProgress', function (up, file) {
        $('#' + file.id).find('.bar').css('width', file.percent + '%');
    });

    uploader.bind('FileUploaded', function (up, file, response) {
        data = $.parseJSON(response.response);
        console.log(data);
        if (!data.success) {
            for (var key in data.errors) {
                error = data.errors[key];
                $('.page_content').prepend('<div class="alert alert-danger">' + error + '</div>');
                $('#' + file.id).remove();
            }
        } else {
            var current = $('#' + file.id);
            current.find('.slides .item').hide();
            current.find('.slides .item').css('background-image', 'url(' + data.upload[0].url + ')');
            current.find('.slides .item').fadeIn(500);
            current.find('.progress').fadeOut(500);
        }
    });

    (function ($) {
        $('#dropzone').bind({
            dragover: function (e) {
                $(this).addClass('hover');
            },
            dragleave: function (e) {
                $(this).removeClass('hover');
            }
        });
    })(jQuery);
</script>