<!DOCTYPE html>
<html lang="sv">

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<script type="text/javascript"
      		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEPwcCqd8WvKxAz-qE8WcwyniXov8X4m4&sensor=true">
		</script>
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		
		<?php wp_head(); ?>
		
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/lad.css'; ?>">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/unsemantic-grid-responsive.css'; ?>">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/media-queries.css'; ?>">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>	
		
	</head>

	<body>
	
		<?php if(function_exists('hv_ads')) : ?>
			<?php hv_ads(-1); ?>
		<?php endif; ?>
	
		<div id="wrapper" class="grid-container">
			<header id="main-header" class="grid-25">
				<a href="<?php bloginfo('url'); ?>">
					<img alt="logotype" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>">
				</a>
				<hr class="vertical hide-on-mobile">
			</header>
				
			<nav id="main-nav" class="grid-55">
				<?php wp_nav_menu(array(
						'theme_location' => 'primary',
						'container' => false
					)); ?>
			</nav>

			<div id="search-box" class="grid-20">
				<form method="get" id="search-form" action="<?php bloginfo('url'); ?>">
					<fieldset>
						<input id="search-input" class="border-box" type="text" name="s" value="" />
						<input id="search-submit" type="submit" value=" Sök " />
					</fieldset>
				</form>
			</div>

