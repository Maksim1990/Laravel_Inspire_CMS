$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({container: 'body'});
});
$(document).ready(function(){

    $("[data-toggle=users]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#users').html();
        }
    });
    $("[data-toggle=posts_all]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#posts_all').html();
        }
    });
    $("[data-toggle=categories]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#categories').html();
        }
    });


    $("[data-toggle=logged_user]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#logged_user').html();
        }
    });

    //Popover closing code when click on some area
    $(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
            }

        });
    });
});
