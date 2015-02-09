var app = angular.module("myApp",[]);

app.controller("popularEvents", function($scope, $http) {

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

    $scope.like = function(e) {
        var id = $(e.target).data('id');
        $('ul[data-id="'+id+'"] .spinner-like').css('display','inline-block');
        $('ul[data-id="'+id+'"] .like_number').hide();

        $http.get(url+'/likes/create/'+id).
            success(function(data, status, headers, config) {
                if (data.success == true){
                    nblike = $('ul[data-id="'+id+'"] .like_number').html();
                    $('ul[data-id="'+id+'"] .like_number').html(parseInt(nblike)+1).show();
                };

                $('ul[data-id="'+id+'"] .like_number').show()
                $('ul[data-id="'+id+'"] .spinner-like').hide();

                return;
            })
            .error(function(data, status, headers, config) {
              // log error
            });
    }
});
