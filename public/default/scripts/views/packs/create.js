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
                    
                if(responseData.success == true){
                    document.location.href = responseData.redirect;
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
   console.log('lalal');
});



    $('#submitLogin').on('click', function () {
    console.log('123')
});
