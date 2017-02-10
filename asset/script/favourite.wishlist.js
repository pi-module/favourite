/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */
var favoritePopoverTimeoutHandle;

function setFavourite(file, item, table, module, title, modalEnabled, loginLinkLabel) {

    var modalEnabled = (typeof modalEnabled == 'undefined') ? false : true;
    var loginLinkLabel = (typeof loginLinkLabel == 'undefined') ? 'Login' : loginLinkLabel;

    $('.itemUserActivityUser.liked').toggleClass('hide');

    $.ajax({
        type: "POST",
        url: file,
        data: {to: module, table: table, item: item},
        dataType: "json",
        success: function (result) {
            if (result.status == 1) {
                if (result.is == 1) {
                    $('#favourite-' + module + '-' + table + '-' + item).attr('class', 'btn btn-success').html('<i class="fa fa-check"></i> ' + title);
                } else {
                    $('#favourite-' + module + '-' + table + '-' + item).attr('class', 'btn btn-primary').html(title);
                }
            } else {

                clearTimeout(favoritePopoverTimeoutHandle);

                var content = result.message;

                if(modalEnabled){
                    content += '<div class="text-center"><button onclick="$(\'.popover-active\').popover(\'hide\')" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#loginRegisterModal">'+loginLinkLabel+'</button></div>';
                }

                var link = $('#favourite-' + module + '-' + table + '-' + item);

                link.not('.popover-active').addClass('popover-active').popover({
                    trigger: 'manual',
                    placement: 'top',
                    toggle: 'popover',
                    content: content,
                    title: result.title,
                    container: 'body',
                    html: true
                });

                $('.popover-active').not(link).popover('hide');

                link.popover('show');

                favoritePopoverTimeoutHandle = setTimeout(function () {
                    link.popover('hide')
                }, 5000);
            }
        }
    });
}