jQuery(document).ready(function(){
	console.log('hello from JS');

	jQuery('#new-hover-functionality').mouseenter(function(){
		jQuery(this).toggle(' 80.00');
	});
	// jQuery('#new-hover-functionality').mouseenter(function(){
	// 	//jQuery(this).append(' $80.00');
	// 	jQuery(this).append(' 80.00');
	// });
	jQuery('#new-hover-functionality').mouseleave(function(){
		//jQuery(this).append(' $80.00');
		jQuery(this).toggle(' 80.00');
	});
});