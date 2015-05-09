(function($) {
  $.sifs.init({
    containerSelector:  wpifs_options['container'],
    postSelector:       wpifs_options['post'],
    paginationSelector: wpifs_options['pagination'],
    nextSelector:       wpifs_options['next'],
    loadingHtml:        wpifs_options['loading']
  });
})(jQuery);