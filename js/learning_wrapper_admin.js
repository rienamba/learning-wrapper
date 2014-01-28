
		
		
/*Make the Post Metadata Field Repeatable*/
jQuery(document).ready(function($) {
	$('.metabox_submit').click(function(e) {
		e.preventDefault();
		$('#publish').click();
	});
	$('#add-row').on('click', function() {
		var row = $('.empty-row.screen-reader-text').clone(true);
		row.removeClass('empty-row screen-reader-text');
		row.insertBefore('#repeatable-fieldset-one>ul:last');
		return false;
	});
	$('.remove-row').on('click', function() {
		$(this).parents('ul').remove();
		return false;
	});
 

});
<<<<<<< HEAD
						
 jQuery(function($)
        {
            var i=1;
            $('.widefat textarea').each(function(e)
            {
                var id = $(this).attr('id');
 
                if (!id)
                {
                    id = 'customEditor-' + i++;
                    $(this).attr('id',id);
                }
 
                tinyMCE.execCommand('mceAddControl', false, id);
                 
            });
        });
=======

>>>>>>> 3e0e3b1acfe3c183c2af7bf8feceffbc5e1fd429
