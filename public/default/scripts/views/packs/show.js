$('#allstep').change(function(){

  if($(this).is(':checked')){
    $('.detail_pack input').prop('checked', true);
  }else{
    $('.detail_pack input').prop('checked', false);
  }
});

app.controller("pack", function($scope, $http) {
    
    
});

console.log('lala');

app.controller("comments", function($scope, $http) {
    
    
    var actualUrl = window.location.href;
    var slug = actualUrl.split("/").pop();
    
    
    $http.get(url + '/api/comments/get/' + slug).
        success(function(data, status, headers, config) {
            if (typeof data === 'object') {
                console.log(data);
                $scope.data = data;
                
                var comments = data;
                
                $http.get(url + '/likes/user').success(function(data, status, headers, config) {
                    console.log(comments);
                });
                
                $('.spinner').hide();
                return;
            } else {
                return;
            }
        })
        .error(function(data, status, headers, config) {
            
        });
        
    $scope.formData = {};

    $scope.comment = function () {

        var commentData = this.formData;
        var transform = function(data){
            return $.param(data);
        }
        
        console.log(commentData);
        token = $('#inputToken').attr('value');
        commentData['token'] = token;
                    
        $http.post(url + '/api/comments/create/' + slug, commentData, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
            transformRequest: transform
        }).success(function(responseData) {
            console.log(responseData);

            if(responseData.errors != ""){
                for(var error in responseData.errors){
                }
            }
        });
        
    };

});


