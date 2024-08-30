// Mobile Menu
$(document).on('click', '#nav-toggle', function () {

    $('ul.header-nav.responsive').animate({
        height: 'toggle'
    }, 200);

});