import './bootstrap';

$(document).ready(function() {
  $('#per_page')?.on('change', function (e) {
      $(this).parents('form')?.submit()
  })
})
