<div class="breadcrumb">
    <ul>
        <li class="item"><strong>DASHBOARD</strong></li>
    </ul>
</div>
<h3 class="page_title">Tableau de bord</h3>
<div class="page_content">
    <?= Core\Session::getFlash() ?>
    <form action="<?= HTML::link('admin1259/dump') ?>" id="dump">
        <div class="form-control">
            <input type="checkbox" class="checkbox" name="datas" id="datas" value="1" checked="checked">
            <label for="datas">Inclure les données</label>
        </div>
        <div class="form-control">
            <button type="submit" class="btn btn-primary" id="send">Exporter la base de données</button>
        </div>
    </form>
    <h2 class="margtop">Statistiques</h2>
    <div class="row margtop">
        <div class="col-3">
            <div class="bloc red">
                <h3 id="packs"><span class="count"></span></h3>
            </div>
        </div>
        <div class="col-3">
            <div class="bloc blue">
                <h3 id="events"><span class="count"></span></h3>
            </div>
        </div>
        <div class="col-3">
            <div class="bloc green">
                <h3 id="users"><span class="count"></span></h3>
            </div>
        </div>
        <div class="col-3">
            <div class="bloc orange">
                <h3 id="messages"><span class="count">15</span> Messages</h3>
            </div>
        </div>
    </div>

</div>
<script>
    (function () {
        var sendbutton = $('#send');
        var buttonwidth = sendbutton.width();
        var buttontext = sendbutton.text();

        $('#dump').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                dataType: 'json',
                data: {
                    datas: $('#datas:checked').val()
                },
                beforeSend: function(){
                    sendbutton.addClass('btn-default');
                    sendbutton.removeClass('btn-primary');
                    sendbutton.width(buttonwidth);
                    sendbutton.html('<span class="fa fa-circle-o-notch fa-spin"></span>');
                },
                success: function (json) {
                    sendbutton.addClass('btn-primary');
                    sendbutton.removeClass('btn-default');
                    sendbutton.html('Exporter la base de données');

                    $('.alert').remove();

                    $('.page_content').prepend('<div class="alert alert-' + json.status + '">' + json.message + '</div>');
                }
            });
        });

        $.ajax({
            url: "<?= HTML::link('admin1259/packs/count') ?>",
            method: 'POST',
            datatType: 'json',
            beforeSend: function(){
                $('#packs').parent().addClass('loading');
            },
            success: function (json) {
                $('#packs').parent().removeClass('loading');
                plural = json.count != 1 ? 's' : '';
                $('#packs .count').html(json.count + ' Pack' + plural);
            }
        });

        $.ajax({
            url: "<?= HTML::link('admin1259/events/count') ?>",
            method: 'POST',
            datatType: 'json',
            beforeSend: function(){
                $('#events').parent().addClass('loading');
            },
            success: function (json) {
                $('#events').parent().removeClass('loading');
                plural = json.count != 1 ? 's' : '';
                $('#events .count').html(json.count + ' Evénement' + plural);
            }
        });

        $.ajax({
            url: "<?= HTML::link('admin1259/users/count') ?>",
            method: 'POST',
            datatType: 'json',
            beforeSend: function(){
                $('#users').parent().addClass('loading');
            },
            success: function (json) {
                $('#users').parent().removeClass('loading');
                plural = json.count != 1 ? 's' : '';
                $('#users .count').html(json.count + ' Utilisateur' + plural);
            }
        });
    })(jQuery);
</script>