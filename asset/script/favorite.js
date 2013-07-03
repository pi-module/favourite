function Set_Favorite(data, file, item, module) {
   $.ajax({
      type:"POST",
      url:file,
      data:data,
      dataType: "json",
      success:function (result) {
         //$('#favorite-' + module + '-' + item).attr('class', 'disabled').attr('onclick', '');
         if (result.status == 1) {
            if (result.is == 1) {
               $('#favorite-' + module + '-' + item).attr('src', result.img);	
            } else {
               $('#favorite-' + module + '-' + item).attr('src', result.img);	
            }		
         } else {
            $('#favorite-' + module + '-' + item).attr('data-toggle', 'popover').attr('data-placement', 'top').attr('data-content', result.message).popover('show');
            setTimeout(function() {$('#favorite-' + module + '-' + item).popover('hide')}, 3000);
         }
      }
   });
}