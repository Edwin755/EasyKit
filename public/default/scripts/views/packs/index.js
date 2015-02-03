var app = angular.module("myApp",[]);

app.controller("favoriteEvents", function($scope, $http) {
        
    $http.get(url + '/api/events?limit=6').
        success(function(data, status, headers, config) {
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
