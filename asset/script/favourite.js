/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */
var favoritePopoverTimeoutHandle;

function setFavourite(file, item, table, module, icon, modalEnabled, loginLinkLabel, link) {

    if(typeof link == 'undefined'){
        link = null;
    }

    var modalEnabled = (typeof modalEnabled == 'undefined') ? false : modalEnabled == 'true';
    var loginLinkLabel = (typeof loginLinkLabel == 'undefined') ? 'login/register' : loginLinkLabel;

    $('.itemUserActivityUser.liked').toggleClass('d-none');

    $.ajax({
        type: "POST",
        url: file,
        data: {to: module, table: table, item: item},
        dataType: "json",
        success: function (result) {
            if (result.status == 1) {
                if (result.is == 1) {
                    $('#favourite-' + module + '-' + table + '-' + item).html('<i class="fas fa-' + icon + '"></i>');
                } else {
                    $('#favourite-' + module + '-' + table + '-' + item).html('<i class="fas fa-' + icon + '-o"></i>');
                }
            } else {

                clearTimeout(favoritePopoverTimeoutHandle);

                var content = result.message;

                if (modalEnabled) {
                    content += '<div class="text-center"><button type="button" class="btn btn-primary btn-sm popover-connect" data-toggle="modal" data-target="#loginRegisterModal">' + loginLinkLabel + '</button></div>';
                }
                if (link == null) {
                   link = $('#favourite-' + module + '-' + table + '-' + item);
                }

                link.not('.popover-active').addClass('popover-active').popover({
                    trigger: 'manual',
                    placement: 'top',
                    toggle: 'popover',
                    content: content,
                    title: result.title,
                    container: 'body',
                    html: true
                });

                $('.popover-active').popover('hide');

                setTimeout(function() {
                    link.popover('show');
                    $('a.popover-connect').click(
                        function()
                        {
                            link.popover('hide');
                            $('#loginRegisterModal').modal('show');
                        }
                    )
                }, 500);

                favoritePopoverTimeoutHandle = setTimeout(function () {
                    link.popover('hide')
                }, 5000);
            }
        }
    });
}