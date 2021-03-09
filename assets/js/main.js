(function ($) {
    const jQueryBridget = require('jquery-bridget');
    const InfiniteScroll = require('infinite-scroll');
    jQueryBridget('infiniteScroll', InfiniteScroll, $);
    let pathname = document.location.pathname,
        search = document.location.search,
        path = search.length > 0 ? (pathname + search + '&page={{#}}') : (pathname + '?page={{#}}');

    $('.scroll-items-container').infiniteScroll({
        path: path,
        append: '.scroll-item',
        history: false,
    });

}(jQuery));
