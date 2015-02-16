app.controller("register", function($scope, $http) {

    $scope.formData = {};
    
    var sec = 0;

    setInterval(function(){ sec++; return sec;}, 1000);


    $scope.create = function () {
        
        $('.spinner').show();
        $('.block').hide();

        var userInfos = this.formData;
        var transform = function(data){
            return $.param(data);
        }
            
        if(sec > 5){
            $http.post(url + '/api/users/create', userInfos, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                transformRequest: transform
            }).success(function(responseData) {

                if(responseData.errors != ""){
                    $('.notif').html("");
                    for(var error in responseData.errors){
                        $('.notif').append(responseData.errors[error]+'<br/>').addClass('red');
                    }
                }
                    
                if(responseData.success == true){
                    document.location.href = responseData.redirect;
                }

            });
        }else{
            $('.notif').html('Wait for minimum 5 secondes before sending de form').addClass('red');
        }
    };
});
