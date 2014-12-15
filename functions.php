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
		echo make_top($start, $stop);
	}

	public function make_top($start, $stop, $max=3)
	{
		/* Makes a string that contains divs of all of the most recent stories,
		 * where $start and $stop are the ids to start and stop at.
		 */
		$recent = get_most_recent($start, $stop);
		$counter = 0;  // posts echoed
		$post_string = "";

		foreach ($recent as $post) {
			if ($counter < $max) {
				$post_string . make_post($post);
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
		$title = $post_array->post-title;
		return "<div class=\"news\"><h1>$title</h1>$content</div>";
	}

	private function ready_for_sidebar($content, $max_char=400,
				  	 $allowed_tags='<h1><h2><h3><h4><h5><h6><p><img>')
	{
		/* Puts the content into a neat sidebar-like format, cleaning tags. Also
		 * checks if the tailing characters are </p> tags and deals with them
		 * appropriately
		 */
		$small = substr($content, 0, $max_char);
		$stripped = strip_tags($smaller, $allowed_tags);  // no double hyperlink

		foreach (range(1, 4) as $char) {
			$test = $this->is_trail_p($stripped, $char);
			if ($test[1]) {
				return $test[0] . "...</p>";
			} else {
				continue;
			}
		}

		return "$stripped...</p>";  // we have no trailing characeters
	}

	private function is_trail_p($content, $chars)
	{
		/* Checks if the characters on the end of $content are </p> and strips
		 * them, if they are.
		 */
		$end = substr($content, -$chars);
		$compare = substr("</p>", 0, -$chars);
		if ($end == $compare) {
			return array(substr($content, 0, -$chars), 1);
		} else {
			return array($content, 0);  // bool for ready_for_sidebar
		}
	}
}

