(function($) {
  $.sifs.init({
    containerSelector:  wpifs_options['container'],
    postSelector:       wpifs_options['post'],
    paginationSelector: wpifs_options['pagination'],
    nextSelector:       wpifs_options['next'],
    loadingHtml:        '<div class="wpifs-loading">' + wpifs_options['loading'] + '</div>',
    show:               function(elems) {
                          elems.fadeIn(700);
                        }
  });
})(jQuery);