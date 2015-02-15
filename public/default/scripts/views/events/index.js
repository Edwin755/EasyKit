app.controller("allEvents", function($scope, $http) {

    $http.get(url + '/api/events').
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                $scope.data = data;
                var events = data.events;
                
                $http.get(url + '/likes/user').success(function(data, status, headers, config) {
                if (typeof data === 'object') {
                    connect = data.authed;
                    userLikes = data.likes;
                    
                    console.log(userLikes);
                
                events.forEach(function(event){
                     
                    eventid = event.events_id;
                    
                    userLikes.forEach(function(entry) { 
                        
                        if(eventid == entry){
                            nblike = $('#' + eventid + ' .like_number').html();
                            
                            $('#' + eventid + ' .like.on').show();
                            $('#' + eventid + ' .like.off').hide();
                            
                            if(connect == false){
                                $('#' + eventid + ' .like_number').html(parseInt(nblike)+1).show();
                            }
                        }

                    });
                });
                    
                    return;
                    
                } else {
                    return;
                }
            })
            .error(function(data, status, headers, config) {
              // log error
            });
                
                $('.spinner').hide();
                return;
            } else {
                return;
            }
        })
        .error(function(data, status, headers, config) {
          // log error
        });

    $scope.update = function () {

        $('.spinner').show();
        $('.block').hide();


        $http.get(url + '/api/events/?search=' + $scope.search).
            success(function(data, status, headers, config) {
                if (typeof data === 'object') {
                    $scope.data = data;
                    $('.block').show();
                    $('.spinner').hide();
                    return;
                } else {
                    return;
                }
            })
            .error(function(data, status, headers, config) {
                console.log(data);
            });
    }

});
