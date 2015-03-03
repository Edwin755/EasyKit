(function ($) {
    $('.login .sign-up-button').on('click', function (e) {
        e.preventDefault();
        console.log('loulou');

        $.ajax({
            url: url + '/users/signin',
            method: 'post',
            dataType: 'json',
            data: {
                'email': $('#emailLogin').val(),
                'password': $('#passwordLogin').val()
            },
            success: function (data) {
                if (data.authed) {
                    console.log(data);
                    $('#item3').remove();
                    $('#popup').hide();
                    $('#item4').remove();
                    $('#login-popup').hide();
                    $('#buttons').append('<li id="item3"><a href="#">My account</a></li>');
                    $('#buttons').append('<li class="logout"><a href="'+url+'/users/logout"><img src="'+url+'/default/images/logout.png"></a></li>');
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
    
    $('#popupLogin .sign-up-button').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: url + '/users/signin',
            method: 'post',
            dataType: 'json',
            data: {
                'email': $('#popupLogin #emailLoginPopUp').val(),
                'password': $('#popupLogin #passwordLoginPopUp').val()
            },
            success: function (data) {
                if (data.authed) {
                    $('#item3').remove();
                    $('#popup').hide();
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