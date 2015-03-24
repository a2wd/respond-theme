<?php
/* Display comments for respond theme */

/* Return if password is required */
if(post_password_required())
{
	return;
}

if(have_comments() || comments_open())
{	
	echo "<div class='section comments'>";
	if(have_comments())
	{
		printf(__('<h3>Comments for %s</h3>','respond'), get_the_title());

		if(get_comment_pages_count() > 1 && get_option('page_comments'))
		{
			echo "<div class='comments_pages'>";
			paginate_comments_links();
			echo "</div>";
		}

		wp_list_comments();

		if(get_comment_pages_count() > 1 && get_option('page_comments'))
		{
			echo "<div class='comments_pages'>";
			paginate_comments_links();
			echo "</div>";
		}
	}
	else
	{
		printf(__('<h3>There are no comments for %s</h3>','respond'), get_the_title());
	}

	if(comments_open())
	{
		comment_id_fields();
		comment_form();
	}
	echo "</div>";
}

?>
