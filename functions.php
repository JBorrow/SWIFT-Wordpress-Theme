<?php
/* Functions for the SWIFT theme. Created for Durham University's Institute for
 * Computaitonal Cosmology by Josh Borrow on 15/12/2014.
 *
 * Includes the sidebar widget and news page.
 *
 * josh.borrow@gmail.com
 */

class SWIFT_sidebar extends WP_Widget
{
	function __construct()
	{
		return;
	}

	public function widget($start=0, $stop=10000)
	{
		echo $this->make_top($start, $stop);
	}

	public function make_top($start, $stop, $max=3)
	{
		/* Makes a string that contains divs of all of the most recent stories,
		 * where $start and $stop are the ids to start and stop at.
		 */
		
		$recent = $this->get_most_recent($start, $stop);
		$counter = 0;  // posts echoed
		$post_string = "";
		
		foreach ($recent as $post) {
			if ($counter < $max) {
				$this_string = $this->make_post($post);
				$post_string .= $this_string;
				$counter += 1;
			} else {
				break;
			}
		}

		return $post_string;
	}
	
	private function get_most_recent($start, $stop)
	{
		/* Grabs the posts in the range of ids $start to $stop, and makes sure
		 * they are posts rather than pages etc. Then returns a newest first
		 * array of their ids
		 */
		$posts = array();
		$times = array();

		foreach (range($start, $stop) as $post) {
			$this_post = get_post($post);
			if ($this_post->post_type == 'post' &&
				$this_post->post_content != '' &&
				!in_array($this_post->post_date,$times)) { // no doubles
					array_push($posts, $this_post);
					array_push($times, $this_post->post_date);
				}
		}

		array_multisort($times, SORT_DESC, $posts);  // in time order
		return $posts;
	}

	private function make_post($post_array)
	{
		/* Packages the content of a post array up into a string for echoing
		 */
		$content = $this->ready_for_sidebar($post_array->post_content);
		$title = $post_array->post_title;
		$id = $post_array->ID;

		return "<a href=\"index.php?page_id=$id\"><div class=\"news\">
			<h1>$title</h1>$content</div></a>";
	}

	private function ready_for_sidebar($content, $max_char=400,
				  	 $allowed_tags='<h1><h2><h3><h4><h5><h6><p><img><div>')
	{
		/* Puts the content into a neat sidebar-like format, cleaning tags.
		 */
		$small = substr($content, 0, $max_char);
		$stripped = strip_tags($small, $allowed_tags);  // no double hyperlink
		
		return "$stripped...</p>";  // we have no trailing characeters
	}

}

