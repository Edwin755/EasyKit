var app = angular.module("myApp",[]);
    
app.controller("event", function($scope, $http) {
    
    
    var actualUrl = window.location.href;
    var id = actualUrl.split("/").pop();
    
    
    console.log('a');
    $http.get(url + '/api/events/get/' + id).
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                console.log('alala');
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


