jQuery(window).load(function () {
    jQuery('.media-fetcher-masonry').masonry({
        itemSelector: '.masonry-item', // use a separate class for itemSelector, other than .col-
        columnWidth: '.media-fetcher-sizer',
        percentPosition: true,
        horizontalOrder: true,
    });
});