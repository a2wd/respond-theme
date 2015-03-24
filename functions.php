<?php

/* Set content width */
if(!isset($content_width))
{
	$content_width = 400;
}

/* Setup theme details */
function respond_setup()
{
	/* Add theme support for thumbnails/featured images */
	add_theme_support('post-thumbnails');

	/* Set up theme for cbf */
	add_theme_support('cbf', array(
		'search-form', 'comment-form', 'comment-list'
	));

	/* Support for post formats */
	add_theme_support('post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	));

	/* Support for rss feeds */
	add_theme_support('automatic-feed-links');

	/* Support for custom background & header */
	add_theme_support('custom-background');
	add_theme_support('custom-header', array('default-color'=>'222228'));

	/* Add styles for editor */
	add_editor_style("editor-style.css");
}
add_action( 'after_setup_theme', 'respond_setup' );

/* Provide thumbnails */
function respond_thumbnail()
{
	if(has_post_thumbnail())
	{
		return get_the_post_thumbnail();
	}
	else
	{
		return "";
	}
}

/* Support comments */
function respond_comments()
{
	$args = array(
		'echo' => false
	);
	$output = wp_list_comments($args);
	if($output != "")
	{
		$output = "<p class='meta'>$output</p>";
	}

	return $output;
}

/* Register sidebar */
function respond_sidebar()
{

	$args = array(
		'id'            => 'respond-sidebar',
		'name'          => __( 'respond Sidebar', 'respond' ),
		'description'   => __( 'Default Sidebar for Respond Theme', 'respond' ),
		'before_title'  => '<h2 class="widget_name">',
		'after_title'   => '</h2>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);
	register_sidebar($args);
}
// Hook into the 'widgets_' action
add_action('widgets_init', 'respond_sidebar');

/* Register navigation menu */
function respond_nav_menu()
{
	register_nav_menu('nav-menu',__( 'Nav Menu', 'respond' ));
}
add_action( 'init', 'respond_nav_menu' );

/* Load stylesheet & and scripts */
function respond_scripts()
{
	wp_enqueue_style('respond-main', get_stylesheet_uri());
	wp_enqueue_style( 'respond-font', respond_font_url(), array(), null );
}
add_action('wp_enqueue_scripts', 'respond_scripts');

/* Allow threaded comments */
function respond_comments_reply()
{
	global $wp_scripts;
	$wp_scripts->add_data('comment-reply', 'group', 1);
	if(get_option('thread_comments'))
	{
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'respond_comments_reply');


/* Theme specific functions */
//==========================//

/* Format classes on posts */
function respond_classes()
{
	$classes = get_post_class();
	$output = "";
	foreach($classes as $class)
	{
		$output .= $class . " ";
	}
	if($class !== "")
	{
		$output = " class='section $output'";
	}
	return $output;
}

/* Format tags for display */
function respond_tags()
{
	$tags = get_the_tags();
	$output = "";
	$first = true;
	if($tags)
	{
		$output = "<span class='tags'>";
		foreach($tags as $tag)
		{
			/* Only add the seperator after the first tag */
			$seperator = " / ";
			if($first)
			{
				$first = false;
				$seperator = "";
			}

			$output .= sprintf("%s<span class='tag'><a href='%s'>%s</a></span>",
				$seperator,
				get_tag_link($tag->term_id),
				$tag->name
			);
		}
		$output .= "</span>";
	}
	return $output;
}

/* Inline javacsript for mobile menu */
function respond_mobile_menu()
{
	$output =	"<script type='text/javascript'>\n\t"
		. "var t = document.getElementById('top-menu');\n\t"
		. "t.className = t.className + ' hide';\n\n\t"
		. "document.getElementById('mobile-nav-toggle').onclick = function(){\n\t"
		. "var c = t.className.split(' ');\n\t"
		. "var i = c.indexOf('hide');\n\t"
		. "if(i === -1) {\n\t\t"
		. "t.className = t.className + ' hide';\n\t}\n\t"
		. "else {\n\t\t"
		. "t.className = c.splice(i+1, 1).join(' ');\n\t}\n};\n"
		. "</script>\n";
	echo $output;
}

// Register google-hosted Source Sans Pro Font
function respond_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Source Sans Pro, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Source sans font: on or off', 'respond' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Source Sans Pro' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

// Custom output for title tag
function respond_title($title, $sep)
{
	global $page, $paged;

	if(is_feed())
	{
		return $title;
	}

	$title .= get_bloginfo("name");

	//Add site description on home page
	$site_description = get_bloginfo("description", "display");
	if($site_description && (is_home() || is_front_page()))
	{
		return "$title $sep $site_description";
	}

	//Add page numbers where necessary
	if($page >= 2 || $paged >= 2)
	{
		return "$title $sep " . sprintf(__("page %s", "a2wp"), max($page, $paged));
	}

	return $title;
}
add_filter('wp_title', 'respond_title', 10, 2);
