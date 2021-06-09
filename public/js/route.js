
$( document ).ready(function() {
  const route = window.location.href;
  if(route.match(/employee/g)) {
    $('.nav-link-employees').addClass('active');
  }
  if(route.match(/positions/g)) {
    $('.nav-link-positions').addClass('active');
  }
});
