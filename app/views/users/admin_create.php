<div class="breadcrumb">
    <ul>
        <li class="item"><strong><a href="<?= HTML::link('admin1259') ?>">DASHBOARD</a></strong></li>
        <li class="item"><a href="<?= HTML::link('admin1259/users') ?>">Utilisateurs</a></li>
        <li class="item current">Ajout d'un utilisateur</li>
    </ul>
</div>
<h3 class="page_title">Ajout d'un utilisateur</h3>
<div class="page_content">
    <form action="<?= HTML::link('api/users/create') ?>" method="post" id="form">
        <h6>Informations de connexion</h6>

        <div class="form-control inline">
            <label for="email">E-mail<span class="required">*</span></label>
            <input class="input" id="email" name="email" type="email" placeholder="E-mail" required autofocus>
        </div>
        <div class="form-control inline">
            <label for="password">Mot de passe<span class="required">*</span></label>
            <input class="input" id="password" name="password" type="password" placeholder="Mot de passe" required>
        </div>

        <h6 class="margtop">Données personnelles</h6>
        <div class="form-control inline">
            <label for="lastname">Nom</label>
            <input class="input" id="lastname" name="lastname" type="text" placeholder="Nom">
        </div>
        <div class="form-control inline">
            <label for="firstname">Prénom</label>
            <input class="input" id="firstname" name="firstname" type="text" placeholder="Prénom">
        </div>
        <div class="form-control">
            <button class="btn btn-primary" id="send">Ajouter</button>
        </div>
    </form>
</div>
<script>
    (function ($) {
        $('#form').on('submit', function (e) {
            e.preventDefault();

            var me = $(this),
                url = me.attr('action'),
                sendbutton = $('#send');

            $.ajax({
                'method': 'POST',
                'url': url,
                'dataType': 'json',
                'data': {
                    'email': $('#email').val(),
                    'password': $('#password').val(),
                    'lastname': $('#lastname').val(),
                    'firstname': $('#firstname').val()
                },
                beforeSend: function(){
                    sendbutton.removeClass('btn-primary');
                    sendbutton.addClass('btn-default');
                    sendbutton.html('<span class="fa fa-circle-o-notch fa-spin"></span>');
                },
                success: function(json){
                    sendbutton.removeClass('btn-default');
                    sendbutton.addClass('btn-primary');
                    sendbutton.text('Ajouter');
                    console.log(json.errors);
                    var status;
                    var msg;
                    if (json.success == false) {
                        status = 'danger';
                        msg = 'Une erreur est survenue:<ul>';
                        for (var i in json.errors) {
                            msg += '<li>' + json.errors[i] + '</li>';
                        }
                        msg += '</ul>';
                        $('#password').val('');
                    } else {
                        status = 'success';
                        msg = 'L\'utilisateur ' + $('#email').val() + ' a bien été créé.';
                        $('#email').val('');
                        $('#password').val('');
                        $('#lastname').val('');
                        $('#firstname').val('');
                    }

                    $('.alert').remove();

                    $('.page_content').prepend('<div class="alert alert-' + status + '">' + msg + '</div>');
                }
            });
        });
    })(jQuery);
</script>