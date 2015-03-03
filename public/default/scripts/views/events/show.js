app.controller("event", function($scope, $http) {
    
    
    var actualUrl = window.location.href;
    var id = actualUrl.split("/").pop();
    
    
    $http.get(url + '/api/events/get/' + id).
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                console.log(data);
                $scope.data = data;
                
                var events = data;
                
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
                }
                });
                
                $('.spinner').hide();
                return;
            } else {
                return;
            }
        })
        .error(function(data, status, headers, config) {
            
        });
        
});


