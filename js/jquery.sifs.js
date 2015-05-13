(function($) {
  $.sifs = {
    containerSelector:  '.sifs-container',
    postSelector:       '.sifs-post',
    paginationSelector: '.sifs-pagination',
    nextSelector:       'a.sifs-next',
    loadingHtml:        'Loading...',
    show:               function(elems) { elems.show(); },
    nextPageUrl:        null,

    init: function(options) {
      for (var key in options) {
        $.sifs[key] = options[key];
      }

      $(function() {
        $.sifs.extractNextPageUrl($('body'));
        $(window).bind('scroll', $.sifs.scroll);
        $.sifs.scroll();
      });
    },
    
    scroll: function() {
      if ($.sifs.nearBottom() && $.sifs.shouldLoadNextPage()) {
        $.sifs.loadNextPage();
      }
    },
    
    nearBottom: function() {
      var scrollTop = $(window).scrollTop(),
          windowHeight = $(window).height(),
          lastPostOffset = $($.sifs.containerSelector).find($.sifs.postSelector).last().offset();

      if (!lastPostOffset) return;
      return (scrollTop > (lastPostOffset.top - windowHeight));
    },

    shouldLoadNextPage: function() {
      return !!$.sifs.nextPageUrl;
    },
    
    loadNextPage: function() {
      var nextPageUrl = $.sifs.nextPageUrl,
          loading = $($.sifs.loadingHtml);
      $.sifs.nextPageUrl = null;
      loading.appendTo($.sifs.containerSelector);
      $.get(nextPageUrl, function(html) {
        var dom = $(html),
            posts = dom.find($.sifs.containerSelector).find($.sifs.postSelector);
        loading.remove();
        $.sifs.show(posts.hide().appendTo($.sifs.containerSelector));
        $.sifs.extractNextPageUrl(dom);
        $.sifs.scroll();
      });
    },

    extractNextPageUrl: function(dom) {
      var pagination = dom.find($.sifs.paginationSelector);
      $.sifs.nextPageUrl = pagination.find($.sifs.nextSelector).attr('href');
      pagination.remove();
    }
  }
})(jQuery);