$(function() {
  $('.range-group').each(function() {
    for (var i = 0; i < 5; i ++) {
      $(this).append('<a>');
    }
  });
  $('.range-group>a').on('click', function() {
     var index = $(this).index();
    $(this).siblings().removeClass('on');
     for (var i = 0; i < index; i++) {
        $(this).parent().find('a').eq(i).addClass('on');
     }
    $(this).parent().find('.input-range').attr('value', index);
  });
});