var app = angular.module("myApp",[]);

app.controller("allEvents", function($scope, $http) {
        
    $http.get(url + '/api/events').
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                $scope.data = data;
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
