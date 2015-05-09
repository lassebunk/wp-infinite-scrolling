(function($) {
  $.wpifs = {
    containerSelector: wpifs_options['container'],
    postSelector: wpifs_options['post'],
    paginationSelector: wpifs_options['pagination'],
    nextSelector: wpifs_options['next'],
    loadingHtml: wpifs_options['loading'],
    nextPageUrl: null,

    init: function() {
      $(function() {
        $.wpifs.extractNextPageUrl($('body'));
        $(window).bind('scroll', $.wpifs.scroll);
        $.wpifs.scroll();
      });
    },
    
    scroll: function() {
      if ($.wpifs.nearBottom() && $.wpifs.shouldLoadNextPage()) {
        $.wpifs.loadNextPage();
      }
    },
    
    nearBottom: function() {
      var scrollTop = $(window).scrollTop(),
          windowHeight = $(window).height(),
          lastPostTop = $($.wpifs.containerSelector).find($.wpifs.postSelector).last().offset().top;

      return (scrollTop > (lastPostTop - windowHeight));
    },

    shouldLoadNextPage: function() {
      return (!!$.wpifs.nextPageUrl);
    },
    
    loadNextPage: function() {
      var nextPageUrl = $.wpifs.nextPageUrl;
      $.wpifs.nextPageUrl = null;
      $($.wpifs.containerSelector).append('<div class="wpifs-loading">' + $.wpifs.loadingHtml + '</div>');
      $.get(nextPageUrl, function(html) {
        var dom = $(html),
            posts = dom.find($.wpifs.containerSelector).find($.wpifs.postSelector);
        $('.wpifs-loading').remove();
        posts.hide().appendTo($.wpifs.containerSelector).fadeIn(700);
        $.wpifs.extractNextPageUrl(dom);
        $.wpifs.scroll();
      });
    },

    extractNextPageUrl: function(dom) {
      var pagination = dom.find($.wpifs.paginationSelector);
      $.wpifs.nextPageUrl = pagination.find($.wpifs.nextSelector).attr('href');
      pagination.remove();
    }
  }

  $.wpifs.init();
})(jQuery);