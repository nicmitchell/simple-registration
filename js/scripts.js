function register_user(data){
// {
//   username: 'jackdoe',
//   password: 'password',
//   email: 'nicolas.aurelius@gmail.com'
// })

  $.ajax({
    url: 'register.user.php',
    type: 'POST',
    data: data,
  }).done(function(data, status, request) {
    // console.log('data', data);
    data = JSON.parse(data);
    $('.alert-box.' + data.status + '').text(data.message).show().css('display', 'block');
    console.log(data.status, data.message);

    if(data.status === 'success'){
      $('form').fadeOut();
    }
  })
  .fail(function(request, status, error) {
    // Uh oh! Ajax fail!
    $('.alert-box.error').text('Something went wrong. Please try again.').show().css('display', 'block');
  });
}

function reset_password(data){
  $.ajax({
    url: 'reset.password.php',
    type: 'POST',
    data: data,
  }).done(function(data, status, request) {
    // console.log('data', data);
    data = JSON.parse(data);
    $('.alert-box.' + data.status + '').text(data.message).show().css('display', 'block');
    console.log(data.status, data.message);

    if(data.status === 'success'){
      $('form').fadeOut();
    }
  })
  .fail(function(request, status, error) {
    // Uh oh! Ajax fail!
    $('.alert-box.error').text('Something went wrong. Please try again.').show().css('display', 'block');
  });
}

function process_submit(event){
  event.preventDefault();
  var fields = {};
  $("form").find("input").each(function() {
    fields[this.name] = $(this).val();
  });
  $('.alert-box').hide();
  register_user(fields);
}

function process_reset(event){
  event.preventDefault();
  var fields = {};
  $("form").find("input").each(function() {
    fields[this.name] = $(this).val();
  });
  $('.alert-box').hide();
  reset_password(fields);
}

$(function() {
$(document).foundation();
  $('button.register').on('click', function(){
    process_submit(event);
  });
  $('button.reset').on('click', function(){
    process_reset(event);
  });
});