<!doctype html>
<!--[if lt IE 9]><html class="ie" <?php language_attributes(); ?>><![endif]-->
<!--[if gte IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<title><?php wp_title('|', true, "right"); ?></title>
    <?php wp_head(); ?>    
  </head>  
	<body lang="en" <?php body_class(); ?>>
		<div class='main'>
<?php if(get_custom_header()->height !== 0) : ?>
			<div class="header_image">
				<img src="<?php header_image(); ?>"
					height="<?php echo get_custom_header()->height; ?>"
					width="<?php echo get_custom_header()->width; ?>" alt="" />
			</div>
<?php endif; ?>
			<div class='header'>
<?php if(get_header_textcolor() != "blank") : ?>
				<h1 class="site-title site-description">
					<a	href="<?php echo esc_url(home_url()); ?>"
							title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
							rel="home"><?php bloginfo( 'name' ); ?>
					| <?php bloginfo( 'description' ); ?></a>
				</h1>
<?php endif; ?>
<?php
				if(has_nav_menu("nav-menu"))
				{
					echo "<div class='nav top-nav'>";
					echo "\t<div id='mobile-nav-toggle'>Menu &nbsp; &#9776;</div>";
					$options = array(
						'theme_location'  => 'nav-menu',
						'container'       => 'div',
						'container_id'    => 'top-menu',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
					);
					wp_nav_menu($options);
					echo "</div>";
				}
?>
		</div>
