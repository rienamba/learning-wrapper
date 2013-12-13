
		
		
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
 
	$('#repeatable-fieldset-one').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});
});
						