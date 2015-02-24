var app = angular.module("myApp",[]);

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
        
        
    


    $scope.fillform = function (e) {
        
        var id = $(e.target).data('id');
        
        $http.get(url + '/api/events/get/' + id).
            success(function(data, status, headers, config) {
                if (typeof data === 'object') {
                    console.log(id);
                    $scope.eventLocation = data.event.events_address;
                    $scope.eventName = data.event.events_name;
                    $scope.eventDesc = data.event.events_description;
                    var datestart = (data.event.events_starttime).substring(0,16);
                    $scope.eventStartDate = datestart.replace(" ", "T");
                    var dateend = (data.event.events_endtime).substring(0,16);
                    $scope.eventEndDate = dateend.replace(" ", "T");          
                    $scope.eventName = data.event.events_name;


                    console.log(data.event.events_name);
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

jQuery(function($){
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
     
    document.getElementById('start-upload').onclick = function() {
      uploader.start();
    };
});




