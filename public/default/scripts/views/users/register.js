var app = angular.module("myApp",[]);

app.controller("register", function($scope, $http) {

    $scope.formData = {};
    
    var sec = 0;

    setInterval(function(){ sec++; console.log(sec); return sec;}, 1000);


    $scope.create = function () {
        
        $('.spinner').show();
        $('.block').hide();

        var userInfos = this.formData;
        var transform = function(data){
            return $.param(data);
        }
            
        if(sec > 5){
            $http.post(url + '/users/register', userInfos, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                transformRequest: transform
            }).success(function(responseData) {
                console.log(responseData);
                if(responseData.errors != ""){
                    $('.notif').html(responseData.errors).addClass('red');
                }
            });
        }else{
            $('.notif').html('Wait for minimum 5 secondes before sending de form').addClass('red');
        }
    };
});
