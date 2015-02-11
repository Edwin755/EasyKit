app.controller("popularEvents", function($scope, $http) {
        
    $http.get(url + '/api/events?limit=6').
        success(function(data, status, headers, config) {
            if(typeof data === 'object'){
                $scope.data = data;  
                 var events = data.events;

            
            $http.get(url + '/likes/user').
                success(function(data, status, headers, config) {
                    if (typeof data === 'object') {
                        userLikes = data.likes;
                    
                    events.forEach(function(event){
                         
                        eventid = event.events_id;
                        
                        userLikes.forEach(function(entry) { 
                            
                            if(eventid == entry){
                                nblike = $('#' + eventid + ' .like_number').html();
                                
                                $('#' + eventid + ' .like.on').show();
                                $('#' + eventid + ' .like.off').hide();
                                $('#' + eventid + ' .like_number').html(parseInt(nblike)+1).show();
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
                
                
                /*
                
*/



                $('.spinner').hide();
                return;
            }else{
                return;
            }
        })
        .error(function(data, status, headers, config) {
          // log error
        });
    
});
