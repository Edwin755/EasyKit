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
  $('.droparea').dropfile({
	  message : '',
	  script : '../api/events/image/43',
	  clone: false
  });
});



