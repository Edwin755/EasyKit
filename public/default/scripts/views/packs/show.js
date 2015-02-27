$('#allstep').change(function(){

  if($(this).is(':checked')){
    $('.detail_pack input').prop('checked', true);
  }else{
    $('.detail_pack input').prop('checked', false);
  }
});

app.controller("pack", function($scope, $http) {
    
    
});
