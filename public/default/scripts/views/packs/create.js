var app = angular.module("myApp",[]);

app.controller("register", function($scope, $http) {

    $scope.formData = {};
    
    var sec = 0;

    setInterval(function(){ sec++; return sec;}, 1000);
    
    $('.clear').on('click',function(){
        $('#formu_event #first_part input, #formu_event #first_part textarea').prop('disabled', false);
        $('#formu_event #first_part input:not("#inputToken"), #formu_event #first_part textarea').val('');
        $('#formu_event #first_part input:not([type="number"]), #formu_event #first_part textarea').css('background', '#fff');
        $('#uploader').show(); 

        console.log('lala');
    });



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
                    
                    $scope.formData.token = data.token;

    
                    if(responseData.errors != ""){
                        $('.notif').html("");
                        
                        
                        for(var error in responseData.errors){
                            $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                        }
                    }
                    
                    $('#popup .sign-up.login').toggle(); 
                    $('#popup .sign-up.register').toggle(); 
                        

    
                });
            }else{
                $('.notif').html('Wait for minimum 5 secondes before sending de form').addClass('red');
            }
    };
});


app.controller("packCreate", function($scope, $http) {
    
    
    $http.get(url + '/packs/temporary').
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                $scope.formData.events_id = data.events_id;
                $scope.formData.events_address = data.events_address;
                $scope.formData.events_name = data.events_name;
                $scope.formData.events_price = parseInt(data.events_price);
                $scope.formData.events_description = data.events_description;
                var datestart = (data.events_starttime).substring(0,16);
                $scope.formData.events_starttime = datestart.replace(" ", "T");
                var dateend = (data.events_endtime).substring(0,16);
                $scope.formData.events_endtime = dateend.replace(" ", "T");          
                $scope.formData.events_name = data.events_name;
                if(data.events_id != ""){
                    $('#formu_event #first_part input:not([type="number"]), #formu_event #first_part textarea').prop('disabled', true);
                    $('#formu_event #first_part input:not([type="number"]), #formu_event #first_part textarea').css('background', '#dddddd');
                    $('#uploader').hide();  
                }

                return;
            } else {
                return;
            }
        })
        .error(function(data, status, headers, config) {
            console.log(data);
        });
    
    

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
        

        
    $scope.formData = {};
        
    $scope.create = function () {
        
        var packsInfo = this.formData;
        var transform = function(data){
            return $.param(data);
        }
        
        $http.post(url + '/packs/temporary', packsInfo, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
            transformRequest: transform
        }).success(function(responseData) {
            
            if(responseData.errors != ""){
                $('.notif').html("");
                for(var error in responseData.errors){
                    $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                }
            }                     
        });
        
        if($('#item3 a').html() == "My account"){
            
            $('#popup-loading').fadeIn(300,function(){
                messages = ["creating pack", "uploading images","setting options","managing moneypot","redirecting to your pack"];
                time = 0;
                messages.forEach(function(entry) {
                    console.log(entry);
                    time += 1000;
                    setTimeout(function(){
                        $('p#loading-messages').fadeOut(100,function(){
                            $('p#loading-messages').html(entry+"...").fadeIn(100);
                        })
                    }, time) ;
                });   
            });
            
            token = $('#inputToken').attr('value');
            packsInfo['token'] = token;
                            
            $http.post(url + '/packs/store', packsInfo, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                transformRequest: transform
            }).success(function(responseData) {
                console.log(responseData);
                eventId = responseData.events_id;
                packSlugs = responseData.packs_slug;
                console.log(packSlugs);
                
                
                uploader.settings.url = url + "/api/events/image/" + eventId;
                
                console.log(uploader);
                uploader.start();
                
                            setTimeout(function () {
               window.location.href = url + "/packs/show/" +packSlugs;
            }, 6000);

                
                if(responseData.errors != ""){
                    $('.notif').html("");
                    for(var error in responseData.errors){
                        $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                    }
                }                     
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
                    $('#formu_event #first_part input:not([type="number"]), #formu_event #first_part textarea').prop('disabled', true);
                    $('#formu_event #first_part input:not([type="number"]), #formu_event #first_part textarea').css('background', '#dddddd');
                    $('#uploader').hide();  

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
                
            $http.get(url + '/api/events?limit=6').
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
    url             : '../../api/medias/send/',
    multipart       : true,
    urlstream_upload: true,
    filters: [
        {title: 'Images', extensions: 'jpeg,jpg,gif,png'}
    ]
});

uploader.init();

uploader.bind('FilesAdded', function (up, files) {
    $.each(files, function(){
        maxfiles = 3;
        
        if(up.files.length > maxfiles )
                     {
                        up.splice(maxfiles);
                        alert('no more than '+maxfiles + ' file(s)');
                     }
        else{
            var img = new mOxie.Image();

    		img.onload = function() {
    			this.embed($('#template').get(0), {
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
        }
        
    });
    
    $('#dropzone').removeClass('hover');
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

/*
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
*/

$('#dropzone').bind({
    dragover: function (e) {
        $(this).addClass('hover');
    },
    dragleave: function (e) {
        $(this).removeClass('hover');
    }
}); 


