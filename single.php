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
else if(is_single())
{
	$title = "Single post";
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
		$content = get_the_content();
	  $content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		printf(
			"%s<div%s>" .
			"<h3><a href='%s'>%s</a></h3>".
			"%s<p>%s</p>".
			"<p class='meta'><a href='%s'>%s</a>%s</p>".
			"</div>\n",
			$tabs,
			respond_classes(),
			get_permalink(),
			get_the_title(),
			respond_thumbnail(),
			$content,
			get_permalink(),
			get_the_date("d M Y"),
			respond_tags()
		);


		//Single-post pagination
		$args = array(
			'before'           => '<div class="post_pages"><p>'.__('Pages: ', 'respond'),
			'after'            => '</p></div>',
			'link_before'      => '',
			'link_after'       => '',
			'separator'        => ' &nbsp; ',
			'nextpagelink'     => __( 'Next page', 'respond' ),
			'previouspagelink' => __( 'Previous page', 'respond' ),
			'pagelink'         => '%',
			'echo'             => 1
		);
		wp_link_pages($args);
	}
	echo "$tabs</p>";

	//Show comments, if there are any or if they can be added
	if(comments_open() || get_comments_number())
	{
		comments_template();
	}
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
