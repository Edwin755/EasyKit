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
    })(jQuery);
</script>