/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */
function setFavourite(file, item, table, module, title) {
    $.ajax({
        type: "POST",
        url: file,
        data: {to: module, table: table, item: item},
        dataType: "json",
        success: function (result) {
            if (result.status == 1) {
                if (result.is == 1) {
                    $('#favourite-' + module + '-' + table + '-' + item).attr('class', 'btn btn-success').html('<i class="fa fa-heart"></i> ' + title);
                } else {
                    $('#favourite-' + module + '-' + table + '-' + item).attr('class', 'btn btn-primary').html('<i class="fa fa-heart-o"></i> ' + title);
                }
            } else {
                $('#favourite-' + module + '-' + table + '-' + item).popover({
                    trigger: 'hover',
                    placement: 'top',
                    toggle: 'popover',
                    content: result.message,
                    title: result.title,
                    container: 'body'
                }).popover('show');
                setTimeout(function () {
                    $('#favourite-' + module + '-' + table + '-' + item).popover('hide')
                }, 3000);
            }
        }
    });
}