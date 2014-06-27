jQuery(document).ready(function($) {
	moment.lang('sv');
	
	if($('.front-page-posts') !== null) {
		$('.front-page-posts .posts-cont').niceScroll({cursoropacitymin:1});
	}
});