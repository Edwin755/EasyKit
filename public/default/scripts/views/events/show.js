app.controller("event", function($scope, $http) {
    
    
    var actualUrl = window.location.href;
    var id = actualUrl.split("/").pop();
    
    
    $http.get(url + '/api/events/get/' + id).
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                console.log(data);
                $scope.data = data;
                $('.spinner').hide();
                return;
            } else {
                return;
            }
        })
        .error(function(data, status, headers, config) {
            
        });
        
});


