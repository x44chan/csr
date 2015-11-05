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
  
});

$(window).load(function(){  
  $("#fadein").slideDown();
});