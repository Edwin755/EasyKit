(function ($) {
    $('#submitLogin').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: url + '/users/signin',
            method: 'post',
            dataType: 'json',
            data: {
                'email': $('#emailLogin').val(),
                'password': $('#passwordLogin').val()
            },
            success: function (data) {
                console.log(data);
                if (data.authed) {
                    $('#item3').remove();
                    $('#item4').remove();
                    $('#login-popup').hide();
                    $('#buttons').append('<li id="item3"><a href="#">My account</a></li>');
                } else {
                    var ul = '<div class="alert alert-danger">An error occured:<ul>';
                    for (error in data.errors) {
                        ul += '<li>' + data.errors[error] + '</li>';
                    }
                    ul += '</ul></div>';
                    $('.alert.alert-danger').remove();
                    $('#login-popup .login').prepend(ul);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
})(jQuery);