$(document).ready( function () {
  $('#myTable').DataTable( {
    "bFilter": false,
    "bLengthChange": false,
    "iDisplayLength": 15
  });
  $('#myTable2').DataTable( {
    "bFilter": false,
    "bLengthChange": false,
    "iDisplayLength": 15,
    "sorting": false
  });
    //$(".jumbotron").hide().fadeIn();
    

});

$(window).load(function(){
  $(".container-fluid").hide().fadeIn(); 
});