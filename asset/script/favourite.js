function setFavourite(data, file, item, table, module, icon) {
    $.ajax({
        type:"POST",
        url:file,
        data:data,
        dataType: "json",
        success:function (result) {
            if (result.status == 1) {
                if (result.is == 1) {
                    $('#favourite-' + module + '-' + table + '-' + item).html('<i class="fa fa-' + icon + '"></i>');
                } else {
                    $('#favourite-' + module + '-' + table + '-' + item).html('<i class="fa fa-' + icon + '-o"></i>');
                }		
            } else {
                $('#favourite-' + module + '-' + table + '-' + item).popover({trigger: 'hover',  placement: 'top', toggle : 'popover', content : result.message, title: result.title, container: 'body'}).popover('show');
                setTimeout(function() {$('#favourite-' + module + '-' + table + '-' + item).popover('hide')}, 3000);
            }
        }
    });
}