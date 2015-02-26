var app = angular.module("myApp",[]);

app.controller("register", function($scope, $http) {

    $scope.formData = {};
    
    var sec = 0;

    setInterval(function(){ sec++; return sec;}, 1000);


    $scope.create = function () {
        
            var userInfos = this.formData;
            var transform = function(data){
                return $.param(data);
            }
                
            if(sec > 5){
                $http.post(url + '/api/users/create', userInfos, {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                    transformRequest: transform
                }).success(function(responseData) {
    
                    if(responseData.errors != ""){
                        $('.notif').html("");
                        for(var error in responseData.errors){
                            $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                        }
                    }
                        
                    if(responseData.success == true){
                        document.location.href = responseData.redirect;
                    }
    
                });
            }else{
                $('.notif').html('Wait for minimum 5 secondes before sending de form').addClass('red');
            }
    };
});


app.controller("packCreate", function($scope, $http) {

    $http.get(url + '/api/events?limit=6').
        success(function(data, status, headers, config) {
            if(typeof data === 'object'){
                $scope.data = data;
                $('.spinner').hide();
                return;
            }else{
                return;
            }
        })
        .error(function(data, status, headers, config) {
          // log error
        });
        
                var uploader = new plupload.Uploader({
                  browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
                  url: '../../api/events/image/43'
                });
                 
                uploader.init();
             
                uploader.bind('FilesAdded', function(up, files) {
                  var html = '';
                  plupload.each(files, function(file) {
                    html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
                  });
                  document.getElementById('filelist').innerHTML += html;
                });
                 
                uploader.bind('UploadProgress', function(up, file) {
                  document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                });
                 
                uploader.bind('Error', function(up, err) {
                  document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                });
        
    $scope.formData = {};
        
    $scope.create = function () {

        if($('#item3 a').html() == "My Account"){
    
            var packsInfo = this.formData;
            var transform = function(data){
                return $.param(data);
            }
            
            token = $('#inputToken').attr('value');
            packsInfo['token'] = token;
            console.log(packsInfo);
                            
            $http.post(url + '/packs/store', packsInfo, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                transformRequest: transform
            }).success(function(responseData) {
    
                if(responseData.errors != ""){
                    $('.notif').html("");
                    for(var error in responseData.errors){
                        $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                    }
                }                 
                
                uploader.start();
    
            });
        }else{
            $('#popup').show();
        }
    };
        
    


    $scope.fillform = function (e) {
        
        var id = $(e.target).data('id');
        
        $http.get(url + '/api/events/get/' + id).
            success(function(data, status, headers, config) {
                if (typeof data === 'object') {
                    console.log(id);
                    $scope.formData.events_id = data.event.events_id;
                    $scope.formData.events_address = data.event.events_address;
                    $scope.formData.events_name = data.event.events_name;
                    $scope.formData.events_description = data.event.events_description;
                    var datestart = (data.event.events_starttime).substring(0,16);
                    $scope.formData.events_starttime = datestart.replace(" ", "T");
                    var dateend = (data.event.events_endtime).substring(0,16);
                    $scope.formData.events_endtime = dateend.replace(" ", "T");          
                    $scope.formData.events_name = data.event.events_name;


                    return;
                } else {
                    return;
                }
            })
            .error(function(data, status, headers, config) {
                console.log(data);
            });
    }

    $scope.update = function () {
        ln = ($scope.search).length;

        if(ln > 2){
            $('.spinner').show();
            $('.vignettes').hide();
            $('.title_favorite_event').html("");
            $http.get(url + '/api/events/?search=' + $scope.search).
                success(function(data, status, headers, config) {
                    if (typeof data === 'object') {
                        $scope.data = data;
                        $('.spinner').hide();
                        $('.vignettes').show();
                        return;
                    } else {
                        return;
                    }
                })
                .error(function(data, status, headers, config) {
                    console.log(data);
                });
        }else{
            $('.title_favorite_event').html("Your favorite Events");
        }
    }
});

$('.allready').on('click',function(){
   $('#popup .sign-up.login').toggle(); 
   $('#popup .sign-up.register').toggle(); 
});


var template = $('#template').html();
// $('#template').children().remove();
var uploader = new plupload.Uploader({
    runtimes        : 'html5',
    container       : 'uploader',
    drop_element    : 'dropzone',
    browse_button   : 'browse',
    url             : '../../api/medias/send',
    multipart       : true,
    urlstream_upload: true,
    filters: [
        {title: 'Images', extensions: 'jpeg,jpg,gif,png'}
    ]
});

uploader.init();

uploader.bind('FilesAdded', function (up, files) {
    $.each(files, function(){
        
		var img = new mOxie.Image();

		img.onload = function() {
			this.embed($('#blah').get(0), {
				width: 100,
				height: 100,
				crop: true
			});
		};

		img.onembedded = function() {
			this.destroy();
		};

		img.onerror = function() {
			this.destroy();
		};

		img.load(this.getSource());        
        
    });
    
    
    $('#dropzone').removeClass('hover');
    // uploader.start();
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
        current.find('.delete').attr('href', '../../api/medias/destroy/' + data.upload[0].medias_id + '');
        current.find('.delete').on('click', function (e) {
            e.preventDefault();

            var me = $(this);

            $.ajax({
                url: $(this).attr('href'),
                dataType: 'json',
                success: function (data) {
                    if (!data.success) {
                        for (var key in data.errors) {
                            error = data.errors[key];
                            $('.page_content').prepend('<div class="alert alert-danger">' + error + '</div>');
                            $('#' + file.id).remove();
                        }
                    } else {
                        current.remove();
                    }
                }
            })
        });
    }
});

$('#dropzone').bind({
    dragover: function (e) {
        $(this).addClass('hover');
    },
    dragleave: function (e) {
        $(this).removeClass('hover');
    }
});


