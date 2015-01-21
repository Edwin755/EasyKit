var app = angular.module("myApp",[]);

app.controller("popularEvents", function($scope, $http) {
        
    $http
        .get(url + '/api/events')
        .success(function(data, status, headers, config) {
            if(typeof data === 'object'){
                $scope.data = data;  
                return;
            }else{
                return;
            }
        })
        .error(function(data, status, headers, config) {
          // log error
        });
    
});
