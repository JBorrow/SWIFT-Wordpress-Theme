<?php
/* Main page for the SWIFT theme. Created for Durham University's Institute for
 * Computaitonal Cosmology by Josh Borrow on 15/12/2014.
 *
 * josh.borrow@gmail.com
 */

$the_title = get_the_title($_GET['page_id']);
get_header();

if ($the_title != 'News') {
	echo "<div class=\"container\">";
	echo "<div class=\"content\">";
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            echo "<h1>";
            the_title();
            echo "</h1>";
            the_content();
        }
	}
	echo "</div>";  // content
	echo "<div class=\"sidebar\">";
	get_sidebar();
	echo "</div>";  // sidebar
	echo "</div>";  // container
} else {
	echo "<div class=\"container\">";
	$news = new SWIFT_sidebar;  // see functions.php
	echo $news->make_top(0, 10000, 50);
	echo "</div>";  // container
}

get_footer();

