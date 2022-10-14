<?php

/**
 * This File is designed for our custom functions
 *
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

/**
 * Nicely format the array
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

function print_a( $a ) {
	print( '<pre>' );
	print_r( $a );
	print( '</pre>' );
}

/**
 * encode the data for testing purposes
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

function creiden_encoder( $a ) {
	echo base64_encode(serialize($a));
}

/**
 * decode the data for testing purposes
 * @since	1.0.0 - 06.23.2013
 * @author	Creiden
 */

function creiden_decoder( $a ) {
	return(unserialize(base64_decode($a)));
}

/**
 * Simple wrapper for native get_template_part()
 * Allows you to pass in an array of parts and output them in your theme
 * e.g. <?php get_template_parts(array('part-1', 'part-2')); ?>
 *
 * @param 	array
 * @return 	void
 * @author 	Keir Whitaker
 **/
function get_template_parts( $parts = array() ) {
	foreach( $parts as $part ) {
		get_template_part( $part );
	};
}

/**
 * Pass in a path and get back the page ID
 * e.g. get_page_id_from_path('about/terms-and-conditions');
 *
 * @param 	string
 * @return 	integer
 * @author 	Keir Whitaker
 **/
function get_page_id_from_path( $path ) {
	$page = get_page_by_path( $path );
	if( $page ) {
		return $page->ID;
	} else {
		return null;
	};
}

/**
 * Get the category id from a category name
 *
 * @param 	string
 * @return 	string
 * @author 	Keir Whitaker
 */
function get_category_id( $cat_name ){
	$term = get_term_by( 'name', $cat_name, 'category' );
	return $term->term_id;
}

function cr_valid($validate) {
	if(isset($validate) && !empty($validate)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function cr_query($arg) {
		$output = get_posts($arg);
		return $output;
}

function cr_end_query() {
	wp_reset_postdata();
}


function cr_get_categories() {
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	return $options_categories;
}

function cr_get_posts() {
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	return $postNames;
}

function string_limit_words($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
    	array_pop($words);
    return implode(' ', $words);
}

function string_limit_characters($string, $character_limit) {
	if(strlen($string) > $character_limit) {
			$string = mb_substr($string,0,$character_limit,'utf-8');
			$string = $string . ' ...';
	}
    return $string;
}

/* ========================================================================================================================

Pagination Function

======================================================================================================================== */
function pagination($pages = '', $range = 4) {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;
	if (! $total_pages > 1) return;
	$rtlNext = '&raquo;';
	$rtlPrev = '&laquo;';
	if(cr_get_option('rtl') == 1){
		$rtlPrev = '&laquo;';
		$rtlNext = '&raquo;';
	}
	$current_page = max(1, get_query_var('paged'));
	$links = paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => '/page/%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'type' => 'array',
			'prev_text' => $rtlPrev,
			'next_text' => $rtlNext
	));
	if(isset($links)&&!empty($links)){
?>
	<div class="pagination grid3">
		<ul>
	<?php foreach($links as $link):
		$current = (preg_match("/class=['\"][\w\s-_]*current/", $link) !== 0) ? 'class="current"' : '';
		$link = preg_replace("/class=['\"](.*?)current(.*?)['\"]/", "class=\"$1 $2\"", $link);
		$link = preg_replace("/class=['\"](.*?)['\"]/", "class=\"$1 inactive\"", $link)
	?>
		<li <?php echo $current?>><?php echo $link?></li>
	<?php endforeach; ?>
		</ul>
	</div>
		<?php }
}
function creiden_pagination($args) {
	global $wp_query;
	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query( $args );
	if ((function_exists("pagination"))) {
		pagination();
	} else {
		wp_link_pages();
	}
	 $wp_query = $temp;
}
