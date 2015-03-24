<?php
get_header();

global $wp_query;
$title = "";

if(is_search())
{
	$title = "Search: " . get_search_query();
}
else if(is_page())
{
	if(is_front_page())
	{
		$title = "Home";
	}
	else
	{
		$title = "Page";
	}
}
else if(is_archive())
{
	$title = "Archive: ";
	$title .= wp_title(" ", false, "right");
}
else
{
	$title = "Blog";
}

echo "\t\t\t\t<div class='article'>\n";
$tabs = str_repeat("\t",5);
echo "$tabs<div class='section title'><h2>$title</h2></div>";

if(have_posts())
{
	while(have_posts())
	{
		the_post();
		$p_text = (is_single() || is_page() || $title === "Home") ? get_the_content() : get_the_excerpt();

		printf(
			"%s<div%s>" .
			"<h3><a href='%s'>%s</a></h3>".
			"<p>%s</p>".
			"<p class='meta'><a href='%s'>%s</a>%s</p>".
			"</div>\n",
			$tabs,
			respond_classes(),
			get_permalink(),
			get_the_title(),
			$p_text,
			get_permalink(),
			get_the_date("d M Y"),
			respond_tags()
		);
	}
	//Index/archive pagination
	echo "$tabs<div class='pages'><p>";
	$args = array(
		'format'       => '?paged=%#%',
		'total'        => $wp_query->max_num_pages,
		'current'      => max(1, get_query_var('paged')), 
		'prev_text'    => '&laquo;',
		'next_text'    => '&raquo;'
	);
	echo paginate_links($args);
	echo "$tabs</p></div>";
}
else
{
	echo "$tabs<div class='section'>\n";
	echo "$tabs\t<h3>No Posts</h3>\n";
	echo "$tabs\t<p class='message'>Unfortunately, there are no posts to display here</p>";
	echo "$tabs</div>\n";
}

echo "\t\t\t\t</div>";

get_sidebar();
get_footer();

?>
