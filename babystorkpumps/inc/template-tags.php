<?php
/** template-tags.php
 *
 * Implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.2.4 - 07.04.2012
 */


if ( ! function_exists( 'creiden_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * To be honest - I'm pretty proud of this function. Through a lot of trial and
 * error, I was able to user a core WordPress function (paginate_links()) and
 * adjust it in a way, that the end result is a legitimate pagination.
 * A pagination many developers buy (code) expensively with Plugins like
 * WP Pagenavi. No need! WordPress has it all!
 *
 * @author	Konstantin Obenland
 * @since	1.0.0 - 05.02.2012
 *
 * @return	void
 */
function creiden_content_nav() {
	global $wp_query, $wp_rewrite;

	$paged			=	( get_query_var( 'paged' ) ) ? intval( get_query_var( 'paged' ) ) : 1;

	$pagenum_link	=	html_entity_decode( get_pagenum_link() );
	$query_args		=	array();
	$url_parts		=	explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}
	$pagenum_link	=	remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link	=	trailingslashit( $pagenum_link ) . '%_%';

	$format			=	( $wp_rewrite->using_index_permalinks() AND ! strpos( $pagenum_link, 'index.php' ) ) ? 'index.php/' : '';
	$format			.=	$wp_rewrite->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	$links	=	paginate_links( array(
		'base'		=>	$pagenum_link,
		'format'	=>	$format,
		'total'		=>	$wp_query->max_num_pages,
		'current'	=>	$paged,
		'mid_size'	=>	3,
		'type'		=>	'list',
		'add_args'	=>	array_map( 'urlencode', $query_args )
	) );

	if ( $links ) {
		echo "<nav class=\"pagination pagination-centered clearfix\">{$links}</nav>";
	}
}
endif;


if ( ! function_exists( 'creiden_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments pages when applicable
 *
 * @author	Konstantin Obenland
 * @since	1.5.0 - 19.05.2012
 *
 * @return	void
 */
function creiden_comment_nav() {
	if ( get_comment_pages_count() > 1 AND get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav class="comment-nav well">
		<h1 class="assistive-text"><?php _e( 'Comment navigation', 'the-bootstrap' ); ?></h1>
		<div class="nav-previous alignleft"><?php next_comments_link( __( '&larr; Newer Comments', 'the-bootstrap' ) ); ?></div>
		<div class="nav-next alignright"><?php previous_comments_link( __( 'Older Comments &rarr;', 'the-bootstrap' ) ); ?></div>
	</nav>
	<?php endif; // check for comment navigation
}
endif;


if ( ! function_exists( 'creiden_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author,
* comment and edit link
*
* @author	Konstantin Obenland
* @since	1.0.0 - 05.02.2012
*
* @return	void
*/
function creiden_posted_on() {
    $comment_count = wp_count_comments( get_the_ID() )->approved;
	printf( __( '<span class="blog-date">%1$s</span><span class="blog-comments-count"><span class="icon-chat-empty"></span>%2$s</span>', 'the-bootstrap' ),
			esc_html( get_the_date('d M,y') ),
            wp_count_comments( get_the_ID() )->approved
	);
}
endif;


if ( ! function_exists( 'creiden_link_pages' ) ) :
/**
 * Displays page links for paginated posts
 *
 * It's basically the wp_link_pages() function, altered to fit to the Bootstrap
 * markup needs for paginations (unordered list).
 * @see		wp_link_pages()
 *
 * @author	Konstantin Obenland
 * @since	1.1.0 - 09.03.2012
 *
 * @param	array	$args
 *
 * @return	string
 */
function creiden_link_pages( $args = array() ) {
	wp_link_pages( array( 'echo' => 0 ));
	$defaults = array(
		'next_or_number'	=> 'number',
		'nextpagelink'		=> __('Next page', 'the-bootstrap'),
		'previouspagelink'	=> __('Previous page', 'the-bootstrap'),
		'pagelink'			=> '%',
		'echo'				=> true
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'creiden_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= '<nav class="pagination clear"><ul><li><span class="dots">' . __('Pages:', 'the-bootstrap') . '</span></li>';
			for ( $i = 1; $i < ($numpages + 1); $i++ ) {
				$j = str_replace( '%', $i, $pagelink );
				if ( ($i != $page) || ((!$more) && ($page!=1)) ) {
					$output .= '<li>' . _wp_link_page($i) . $j . '</a></li>';
				}
				if ($i == $page) {
					$output .= '<li class="current"><span>' . $j . '</span></li>';
				}

			}
			$output .= '</ul></nav>';
		} else {
			if ( $more ) {
				$output .= '<nav class="pagination clear"><ul><li><span class="dots">' . __('Pages:', 'the-bootstrap') . '</span></li>';
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= '<li>' . _wp_link_page( $i ) . $previouspagelink. '</a></li>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= '<li>' . _wp_link_page( $i ) . $nextpagelink. '</a></li>';
				}
				$output .= '</ul></nav>';
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}
endif;


if ( ! function_exists( 'creiden_navbar_searchform' ) ) :
/**
 * Returns or echoes searchform mark up, specifically for the navbar.
*
* @author	Konstantin Obenland
* @since	1.5,0 - 14.05.2012
*
* @param	bool	$echo	Optional. Whether to echo the form
*
* @return	void
*/
function creiden_navbar_searchform( $echo = true ) {
	$searchform = '	<form id="searchform" class="navbar-search pull-right" method="get" action="' . esc_url( home_url( '/' ) ) . '">
						<label for="s" class="assistive-text hidden">' . __( 'Search', 'the-bootstrap' ) . '</label>
						<input type="search" class="search-query" name="s" id="s" placeholder="' . esc_attr__( 'Search', 'the-bootstrap' ) . '" />
					</form>';

	if ( $echo )
		echo $searchform;

	return $searchform;
}
endif;


if ( ! function_exists( 'creiden_navbar_class' ) ) :
/**
 * Adds The Bootstrap navbar classes
 *
 * @author	WordPress.org
 * @since	1.4.0 - 12.05.2012
 *
 * @return	void
 */
function creiden_navbar_class() {
	$classes	=	array( 'navbar' );

	// if ( 'static' != creiden_options()->navbar_position )
		// $classes[]	=	creiden_options()->navbar_position;
//
	// if ( creiden_options()->navbar_inverse )
		// $classes[]	=	'navbar-inverse';
//
	apply_filters( 'creiden_navbar_classes', $classes );

	echo 'class="' . join( ' ', $classes ) . '"';
}
endif;


if ( ! function_exists( 'creiden_comments_link' ) ) :
/**
 * Displays the link to the comments popup window for the current post ID.
 *
 * Is not meant to be displayed on single posts and pages. Should be used on the
 * lists of posts
 *
 * @since	2.0.0 - 01.09.2012
 *
 * @param	string	$zero		The string to display when no comments
 * @param	string	$one		The string to display when only one comment is available
 * @param	string	$more		The string to display when there are more than one comment
 * @param	string	$css_class	The CSS class to use for comments
 * @param	string	$none		The string to display when comments have been turned off
 *
 * @return	void
 */
function creiden_comments_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	$number = get_comments_number();
	$class  = empty( $css_class ) ? '' : ' class="' . esc_attr( $css_class ) . '"';

	if ( false === $zero ) $zero = __( 'No Comments' );
	if ( false === $one  ) $one  = __( '1 Comment' );
	if ( false === $more ) $more = __( '% Comments' );
	if ( false === $none ) $none = __( 'Comments Off' );

	if ( 0 == $number AND ! comments_open() AND ! pings_open() ) {
		echo '<span' . $class . '>' . $none . '</span>';
		return;
	}

	if ( post_password_required() ) {
		echo '<span' . $class . '>' . __( 'Enter your password to view comments.' ) . '</span>';
		return;
	}

	if ( 1 < $number )
		$comments_number = str_replace( '%', number_format_i18n( $number ), $more );
	else
		$comments_number = ( 0 == $number ) ? $zero : $one;

	$link = sprintf( '<a href="%1$s"%2$s%3s title="%4$s">%5$s</a>',
		( 0 == $number ) ? '#respond' : '#comments',
		$class,
		apply_filters( 'comments_popup_link_attributes', '' ),
		esc_attr( sprintf( __( 'Comment on %s' ), the_title_attribute( array('echo' => 0 ) ) ) ),
		apply_filters( 'comments_number', $comments_number, $number )
	);

	echo apply_filters( 'creiden_comments_link', $link, $zero, $one, $more, $css_class, $none );
}
endif;


/* End of file template-tags.php */
/* Location: ./wp-content/themes/the-bootstrap/inc/template-tags.php */