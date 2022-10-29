<?php

/** functions.php
 *
 * @author        Konstantin Obenland
 * @package        The Bootstrap
 * @since        1.0.0 - 05.02.2012
 */

require_once __DIR__ . '/multi-step-form/main.php';
require_once __DIR__ . '/multi-step-form/new-form-main.php';
require_once __DIR__ . '/multi-step-form/onestep-form-main.php';
require_once __DIR__ . '/multi-step-form/onestep-form-main-bootsandbabies-t.php';
require_once __DIR__ . '/payers/item_sync_dmez.php';

if (!function_exists('creiden_setup')) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @return    void
	 * @since    1.0.0 - 05.02.2012
	 *
	 * @author    WordPress.org
	 */
	function creiden_setup()
	{
		global $content_width;

		if (!isset($content_width)) {
			$content_width = 770;
		}

		load_theme_textdomain('the-bootstrap', get_template_directory() . '/lang');

		add_theme_support('automatic-feed-links');

		add_theme_support('post-thumbnails');

		// add_theme_support( 'post-formats', array(
		// 'aside',
		// 'chat',
		// 'link',
		// 'gallery',
		// 'status',
		// 'quote',
		// 'image',
		// 'video'
		// ) );

		add_theme_support('tha_hooks', array('all'));

		$args = apply_filters('creiden_custom_background_args', array(
			'default-color' => 'EFEFEF',
		));

		add_theme_support('custom-background', $args);

		/**
		 * Custom template tags for this theme.
		 */
		require_once(get_template_directory() . '/inc/template-tags.php');

		/**
		 * Implement the Custom Header feature
		 */
		require_once(get_template_directory() . '/inc/custom-header.php');

		/**
		 * Woocommerce modification
		 */
		require_once(get_template_directory() . '/inc/woocommerce/main.php');

		/**
		 * Woocommerce additional API
		 */
		require_once(get_template_directory() . '/api/class-customers-additional-api.php');
		require_once(get_template_directory() . '/api/class-orders-additional-api.php');

		/**
		 * Customizer custom options
		 */
		require_once(get_template_directory() . '/inc/customizer.php');

		/**
		 * UTM
		 */
		require_once(get_template_directory() . '/inc/utm.php');

		/**
		 * Creiden Framework.
		 */
		require_once(get_template_directory() . '/inc/crdn-framework.php');
		require_once(get_template_directory() . '/inc/crdn-functions.php');
		/**
		 * Theme Hook Alliance
		 */
		require_if_theme_supports('tha_hooks', get_template_directory() . '/inc/tha-theme-hooks.php');

		/**
		 * Including three menu (header-menu, primary and footer-menu).
		 * Primary is wrapping in a navbar containing div (wich support responsive variation)
		 * Header-menu and Footer-menu are inside pills dropdown menu
		 *
		 * @since    1.2.2 - 07.04.2012
		 * @see        http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus(array(
			'primary'     => __('Main Navigation', 'hfp'),
			'quick-links' => __('Quick Links', 'hfp'),
			'about'       => __('About Homefront', 'hfp'),
		));
	}

// creiden_setup
endif;

add_action('after_setup_theme', 'creiden_setup');

/**
 * Register the sidebars.
 *
 * @return    void
 * @since    1.0.0 - 05.02.2012
 *
 * @author    Konstantin Obenland
 */
function creiden_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Main Sidebar', 'the-bootstrap'),
		'id'            => 'main',
		'before_widget' => '<div id="%1$s" class="widget well %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	));

	register_sidebar(array(
		'name'          => __('Footer Sidebar', 'the-bootstrap'),
		'id'            => 'footer',
		'before_widget' => '<div id="%1$s" class="widget col-sm-4 %2$s">',
		'after_widget'  => '</div><div class="sidebarSeparator"></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}

add_action('widgets_init', 'creiden_widgets_init');

/**
 * Registration of theme scripts and styles
 *
 * @return    void
 * @since    1.0.0 - 05.02.2012
 *
 * @author    Konstantin Obenland
 */
function wp_register_scripts_styles()
{

	if (!is_admin()) {
		$suffix = (defined('SCRIPT_DEBUG') and SCRIPT_DEBUG) ? '' : '.min';

		/**
		 * Scripts
		 */
		wp_register_script('owlcarousel', get_template_directory_uri() . "/assets/js/owl.carousel.min.js", array('jquery'));

		wp_register_script('bootstrap_js', get_template_directory_uri() . "/assets/js/bootstrap.min.js", array('jquery'));

		wp_register_script('mainjs', get_template_directory_uri() . "/assets/js/main.js", array('jquery'));
		wp_register_script('jqueryvalidate', get_template_directory_uri() . "/assets/js/jquery.validate.min.js", array('jquery'));
		wp_register_script('additionalmethods', get_template_directory_uri() . "/assets/js/additional-methods.min.js", array('jquery'));
		wp_register_script('jquerymaskedinput', get_template_directory_uri() . "/assets/js/jquery.maskedinput.min.js", array('jquery'));
		wp_register_script('jquerymaskssn', get_template_directory_uri() . "/assets/js/jquery.maskssn.js", array('jquery'));
		wp_register_script('intlTelInput', get_template_directory_uri() . "/assets/intlTelInput/js/intlTelInput.js", array('jquery'));
		wp_register_script('singup_form',  get_template_directory_uri() . "/templates/onestep-form-bootsandbabies-t/singup_form.js", array('jquery', 'intlTelInput'), time());
		wp_register_script('dmez-payer',  get_template_directory_uri() . "/templates/onestep-form-bootsandbabies-t/dmez-payer.js", array('jquery'));
		

		/**
		 * Styles
		 */
		wp_register_style('ralewaycss', 'https://fonts.googleapis.com/css?family=Raleway:300,500,700,900&display=swap');
		wp_register_style('maincss', get_template_directory_uri() . "/assets/css/main.css", array(), filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
	}
}

add_action('init', 'wp_register_scripts_styles');

/**
 * Properly enqueue frontend scripts
 *
 * @return    void
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_print_scripts()
{
	wp_enqueue_script('owlcarousel');
	wp_enqueue_script('bootstrap_js');
	wp_enqueue_script('mainjs');
	wp_enqueue_script('jqueryvalidate');
	wp_enqueue_script('additionalmethods');
	wp_enqueue_script('jquerymaskedinput');
	wp_enqueue_script('jquerymaskssn');
}

add_action('wp_enqueue_scripts', 'creiden_print_scripts');

/**
 * Properly enqueue backend scripts
 *
 * @return    void
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_admin_print_scripts()
{
	wp_register_script('jqueryvalidate', get_template_directory_uri() . "/assets/js/jquery.validate.min.js", array('jquery'));
	wp_register_script('additionalmethods', get_template_directory_uri() . "/assets/js/additional-methods.min.js", array('jquery'));
	wp_enqueue_script('jqueryvalidate');
	wp_enqueue_script('additionalmethods');
}

add_action('admin_enqueue_scripts', 'creiden_admin_print_scripts');

/**
 * Properly Localize Variables
 *
 * @return    void
 * @since    1.0.0 - 06.26.2013
 *
 * @author    creiden
 */
function creiden_localize_scripts()
{
	wp_localize_script('mainjs', 'global_creiden', array(
		'theme_path' => get_template_directory_uri(),
		'ajax_url'   => admin_url('admin-ajax.php'),
		'post_id'    => is_single() ? get_the_ID() : 0,
		'post_title' => is_single() ? get_the_title() : '',
	));
}

add_action('wp_enqueue_scripts', 'creiden_localize_scripts');
//add_action( 'admin_enqueue_scripts', 'creiden_localize_scripts' );
//add_action( 'wp_enqueue_scripts', 'creiden_localize_scripts', 11 );

/**
 * Adds IE specific scripts
 *
 * Respond.js has to be loaded after Theme styles
 *
 * @return    void
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_print_ie_scripts()
{
?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script>
	<![endif]-->
	<?php
}

add_action('wp_head', 'creiden_print_ie_scripts', 11);

/**
 * Properly enqueue comment-reply script
 *
 * @return    void
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_comment_reply()
{
	if (get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('comment_form_before', 'creiden_comment_reply');

/**
 * Properly enqueue frontend styles
 *
 * Since 'tw-bootstrap' was registered as a dependency, it'll get enqueued
 * automatically
 *
 * @return    void
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_print_styles()
{
	wp_enqueue_style('ralewaycss');
	wp_enqueue_style('maincss');
}

add_action('wp_enqueue_scripts', 'creiden_print_styles');


if (!function_exists('creiden_credits')) {

	/**
	 * Prints HTML with meta information for the current post-date/time and author,
	 * comment and edit link
	 *
	 * @return    void
	 * @since    1.0.0 - 06.23.2013
	 *
	 * @author    creiden
	 */
	function creiden_credits()
	{
		printf(
			'<span class="credits alignleft">' . __('&copy; %1$s <a href="%2$s">%3$s</a>, all rights reserved.', 'the-bootstrap') . '</span>',
			date('Y'),
			home_url('/'),
			get_bloginfo('name')
		);
	}
}

/**
 * Returns the blogname if no title was set.
 *
 * @param string $title
 * @param string $sep
 *
 * @return    string
 * @since    1.0.0 - 06.23.2013
 *
 * @author    creiden
 */
function creiden_wp_title($title, $sep)
{

	if (!is_feed()) {
		$title .= get_bloginfo('name');

		if (is_front_page()) {
			$title .= " {$sep} " . get_bloginfo('description');
		}
	}

	return $title;
}

add_filter('wp_title', 'creiden_wp_title', 1, 2);

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and creiden_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @param string $more
 *
 * @return    string
 * @author    WordPress.org
 * @since    1.0.0 - 05.02.2012
 *
 */
//function creiden_auto_excerpt_more( $more ) {
//	return '&hellip;' . creiden_continue_reading_link();
//}
//
//add_filter( 'excerpt_more', 'creiden_auto_excerpt_more' );
//
///**
// * Adds a pretty "Continue Reading" link to custom post excerpts.
// *
// * To override this link in a child theme, remove the filter and add your own
// * function tied to the get_the_excerpt filter hook.
// *
// * @param string $output
// *
// * @return    string
// * @author    WordPress.org
// * @since    1.0.0 - 05.02.2012
// *
// */
//function creiden_custom_excerpt_more( $output ) {
//	if ( has_excerpt() AND ! is_attachment() ) {
//		$output .= creiden_continue_reading_link();
//	}
//
//	return $output;
//}

//add_filter( 'get_the_excerpt', 'creiden_custom_excerpt_more' );

/**
 * Get the wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args
 *
 * @return    array
 * @author    WordPress.org
 * @since    1.0.0 - 05.02.2012
 *
 */
function creiden_page_menu_args($args)
{
	$args['show_home'] = true;

	return $args;
}

add_filter('wp_page_menu_args', 'creiden_page_menu_args');

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @param string $url
 * @param int $id
 *
 * @return    string
 * @since    1.0.0 - 05.02.2012
 *
 * @author    Automattic
 */
function creiden_enhanced_image_navigation($url, $id)
{

	if (is_attachment() and wp_attachment_is_image($id)) {
		$image = get_post($id);
		if ($image->post_parent and $image->post_parent != $id) {
			$url .= '#primary';
		}
	}

	return $url;
}

add_filter('attachment_link', 'creiden_enhanced_image_navigation', 10, 2);

/**
 * Displays comment list, when there are any
 *
 * @return    void
 * @since    1.7.0 - 16.06.2012
 *
 * @author    Konstantin Obenland
 */
function creiden_comments_list()
{
	if (post_password_required()) :
	?>
		<div id="comments">
			<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'the-bootstrap'); ?></p>
		</div><!-- #comments -->
	<?php
		return;
	endif;


	if (have_comments()) :
	?>
		<div id="comments" class="comments">
			<h6 id="comments-title">
				Comments
			</h6>

			<?php creiden_comment_nav(); ?>

			<ul class="comment-list">
				<?php wp_list_comments(array('callback' => 'creiden_comment')); ?>
			</ul><!-- .commentlist .unstyled -->

			<?php creiden_comment_nav(); ?>

		</div><!-- #comments -->
	<?php
	endif;
}

add_action('comment_form_before', 'creiden_comments_list', 0);
add_action('comment_form_comments_closed', 'creiden_comments_list', 1);

/**
 * Echoes comments-are-closed message when post type supports comments and we're
 * not on a page
 *
 * @return    void
 * @since    1.7.0 - 16.06.2012
 *
 * @author    Konstantin Obenland
 */
function creiden_comments_closed()
{
	if (!is_page() and post_type_supports(get_post_type(), 'comments')) :
	?>
		<p class="nocomments"><?php _e('Comments are closed.', 'the-bootstrap'); ?></p>
		<?php
	endif;
}

add_action('comment_form_comments_closed', 'creiden_comments_closed');

/**
 * Filters comments_form() default arguments
 *
 * @param array $defaults
 *
 * @return    array
 * @author    Konstantin Obenland
 * @since    1.7.0 - 16.06.2012
 *
 */
function creiden_comment_form_defaults($defaults)
{
	return wp_parse_args(array(
		//		'comment_field'			 => '<div class="comment-form-comment control-group"><label class="control-label test" for="comment">' . _x( 'Comment', 'noun', 'the-bootstrap' ) . '</label><div class="controls"><textarea id="comment" name="comment" rows="8" aria-required="true"></textarea></div></div>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		//		'comment_notes_after'	 => '<div class="form-allowed-tags control-group"><label class="control-label">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'the-bootstrap' ), '</label><div class="controls"><pre>' . allowed_tags() . '</pre></div>' ) . '</div>
		//									 <div class="form-actions">',
		//		'title_reply'			 => '<legend>' . __( 'Leave a reply', 'the-bootstrap' ) . '</legend>',
		//		'title_reply_to'		 => '<legend>' . __( 'Leave a reply to <span>%s</span>', 'the-bootstrap' ) . '</legend>',
		//		'must_log_in'			 => '<div class="must-log-in control-group controls">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'the-bootstrap' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</div>',
		//		'logged_in_as'			 => '<div class="logged-in-as control-group controls">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'the-bootstrap' ), admin_url( 'profile.php' ), wp_get_current_user()->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</div>',
	), $defaults);
}

add_filter('comment_form_defaults', 'creiden_comment_form_defaults');

/**
 * Add all user meta when requesting API from wordpress get users API
 */
add_action('rest_api_init', function () {
	register_rest_field(
		'user',
		'user-meta-fields',
		array(
			'get_callback'    => 'user_meta_callback',
			'update_callback' => null,
			'schema'          => null,
		)
	);
});

function user_meta_callback($user)
{
	return get_user_meta($user['id']);
}

if (!function_exists('creiden_comment')) :

	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own creiden_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @param object $comment Comment data object.
	 * @param array $args
	 * @param int $depth Depth of comment in reference to parents.
	 *
	 * @return    void
	 * @author    Konstantin Obenland
	 * @since    1.0.0 - 05.02.2012
	 *
	 */
	function creiden_comment($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		if ('pingback' == $comment->comment_type or 'trackback' == $comment->comment_type) :
		?>

			<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<p>
					<strong class="ping-label"><?php _e('Pingback:', 'the-bootstrap'); ?></strong>
					<span><?php comment_author_link();
								edit_comment_link(__('Edit', 'the-bootstrap'), '<span class="edit-link label">', '</span>');
								?></span>
				</p>

			<?php
		else :
			?>

			<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<article id="comment-<?php comment_ID(); ?>">
					<div class="comment-author-avatar">
						<?php echo get_avatar($comment, 58); ?>
					</div>
					<div class="comment-content">
						<div class="comment-meta">
							<p class="comment-author vcard">
								<?php
								/* translators: 1: comment author, 2: date and time */
								printf(__('%1$s / %2$s', 'the-bootstrap'), sprintf('<span>%s</span>', get_comment_author_link()), sprintf(
									'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url(get_comment_link($comment->comment_ID)),
									get_comment_time('c'),
									/* translators: 1: date, 2: time */
									sprintf(__('%1$s at %2$s', 'the-bootstrap'), get_comment_date('d M,y'), get_comment_time())
								));
								edit_comment_link(__(' - Edit', 'the-bootstrap'), '<span class="edit-link label">', '</span>');
								?>
							</p><!-- .comment-author .vcard -->

							<?php if (!$comment->comment_approved) : ?>
								<div class="comment-awaiting-moderation alert alert-info">
									<em><?php _e('Your comment is awaiting moderation.', 'the-bootstrap'); ?></em></div>
							<?php endif; ?>

						</div><!-- .comment-meta -->

						<div class="comment-text">
							<?php
							comment_text(); ?>
						</div>
						<div class="comment-reply">
							<?php comment_reply_link(array_merge($args, array(
								'reply_text' => __('Reply', 'the-bootstrap'),
								'depth'      => $depth,
								'max_depth'  => $args['max_depth']
							)));
							?>
						</div>
					</div>
				</article><!-- #comment-<?php comment_ID(); ?> -->

	<?php
		endif; // comment_type
	}

endif; // ends check for creiden_comment()


/**
 * Adds markup to the comment form which is needed to make it work with Bootstrap
 * needs
 *
 * @param string $html
 *
 * @return    string
 * @author    Konstantin Obenland
 * @since    1.0.0 - 05.02.2012
 *
 */
function creiden_comment_form()
{
	//		echo '</li>';
}

//add_action( 'comment_form', 'creiden_comment_form' );

/**
 * Adjusts an attechment link to hold the class of 'thumbnail' and make it look
 * pretty
 *
 * @param string $link
 * @param int $id Post ID.
 * @param string $size Default is 'thumbnail'. Size of image, either array or string.
 * @param bool $permalink Default is false. Whether to add permalink to image.
 * @param bool $icon Default is false. Whether to include icon.
 * @param string $text Default is false. If string, then will be link text.
 *
 * @return    string
 * @since    1.0.0 - 05.02.2012
 *
 * @author    Konstantin Obenland
 */
function creiden_get_attachment_link($link, $id, $size, $permalink, $icon, $text)
{
	return (!$text) ? str_replace('<a ', '<a class="thumbnail" ', $link) : $link;
}

add_filter('wp_get_attachment_link', 'creiden_get_attachment_link', 10, 6);

/**
 * Adds the 'hero-unit' class for extra big font on sticky posts
 *
 * @param array $classes
 *
 * @return    array
 * @author    Konstantin Obenland
 * @since    1.0.0 - 05.02.2012
 *
 */
function creiden_post_classes($classes)
{

	if (is_sticky() and is_home()) {
		$classes[] = 'hero-unit';
	}

	return $classes;
}

add_filter('post_class', 'creiden_post_classes');

/**
 * Callback function to display galleries (in HTML5)
 *
 * @param string $content
 * @param array $attr
 *
 * @return    string
 * @since    1.0.0 - 05.02.2012
 *
 * @author    Konstantin Obenland
 */
function creiden_post_gallery($content, $attr)
{
	global $instance, $post;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if (isset($attr['orderby'])) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if (!$attr['orderby']) {
			unset($attr['orderby']);
		}
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'figure',
		'icontag'    => 'div',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));


	$id = intval($id);
	if ('RAND' == $order) {
		$orderby = 'none';
	}

	if ($include) {
		$include      = preg_replace('/[^0-9,]+/', '', $include);
		$_attachments = get_posts(array(
			'include'        => $include,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $order,
			'orderby'        => $orderby
		));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ($exclude) {
		$exclude     = preg_replace('/[^0-9,]+/', '', $exclude);
		$attachments = get_children(array(
			'post_parent'    => $id,
			'exclude'        => $exclude,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $order,
			'orderby'        => $orderby
		));
	} else {
		$attachments = get_children(array(
			'post_parent'    => $id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $order,
			'orderby'        => $orderby
		));
	}

	if (empty($attachments)) {
		return;
	}

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}

		return $output;
	}


	$itemtag    = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns    = intval(min(array(8, $columns)));
	$float      = (is_rtl()) ? 'right' : 'left';

	if (4 > $columns) {
		$size = 'full';
	}

	$selector   = "gallery-{$instance}";
	$size_class = sanitize_html_class($size);
	$output     = "<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} thumbnails'>";

	$i = 0;
	foreach ($attachments as $id => $attachment) {
		$comments = get_comments(array(
			'post_id' => $id,
			'count'   => true,
			'type'    => 'comment',
			'status'  => 'approve'
		));

		$link        = wp_get_attachment_link($id, $size, !(isset($attr['link']) and 'file' == $attr['link']));
		$clear_class = (0 == $i++ % $columns) ? ' clear' : '';
		$span        = 'span' . floor(8 / $columns);

		$output .= "<li class='{$span}{$clear_class}'><{$itemtag} class='gallery-item'>";
		$output .= "<{$icontag} class='gallery-icon'>{$link}</{$icontag}>\n";

		if ($captiontag and (0 < $comments or trim($attachment->post_excerpt))) {
			$comments = (0 < $comments) ? sprintf(_n('%d comment', '%d comments', $comments, 'the-bootstrap'), $comments) : '';
			$excerpt  = wptexturize($attachment->post_excerpt);
			$out      = ($comments and $excerpt) ? " $excerpt <br /> $comments " : " $excerpt$comments ";
			$output   .= "<{$captiontag} class='wp-caption-text gallery-caption'>{$out}</{$captiontag}>\n";
		}
		$output .= "</{$itemtag}></li>\n";
	}
	$output .= "</ul>\n";

	return $output;
}

add_filter('post_gallery', 'creiden_post_gallery', 10, 2);

/**
 * HTML 5 caption for pictures
 *
 * @param string $empty
 * @param array $attr
 * @param string $content
 *
 * @return    string
 * @author    Konstantin Obenland
 * @since    1.0.0 - 05.02.2012
 *
 */
function creiden_img_caption_shortcode($empty, $attr, $content)
{

	extract(shortcode_atts(array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr));

	if (1 > (int) $width or empty($caption)) {
		return $content;
	}

	if ($id) {
		$id = 'id="' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption thumbnail ' . $align . '" style="width: ' . $width . 'px;">
				' . do_shortcode(str_replace('class="thumbnail', 'class="', $content)) . '
				<figcaption class="wp-caption-text">' . $caption . '</figcaption>
			</figure>';
}

add_filter('img_caption_shortcode', 'creiden_img_caption_shortcode', 10, 3);

/**
 * Returns a password form which dispalys nicely with Bootstrap
 *
 * @param string $form
 *
 * @return    string    The Bootstrap password form
 * @author    Konstantin Obenland
 * @since    1.0.0 - 05.02.2012
 *
 */
function creiden_the_password_form($form)
{
	return '<form class="post-password-form form-horizontal" action="' . home_url('wp-pass.php') . '" method="post"><legend>' . __('This post is password protected. To view it please enter your password below:', 'the-bootstrap') . '</legend><div class="control-group"><label class="control-label" for="post-password-' . get_the_ID() . '">' . __('Password:', 'the-bootstrap') . '</label><div class="controls"><input name="post_password" id="post-password-' . get_the_ID() . '" type="password" size="20" /></div></div><div class="form-actions"><button type="submit" class="post-password-submit submit btn btn-primary">' . __('Submit', 'the-bootstrap') . '</button></div></form>';
}

add_filter('the_password_form', 'creiden_the_password_form');

/**
 * Modifies the category dropdown args for widgets on 404 pages
 *
 * @param array $args
 *
 * @return    array
 * @author    Konstantin Obenland
 * @since    1.5.0 - 19.05.2012
 *
 */
function creiden_widget_categories_dropdown_args($args)
{
	if (is_404()) {
		$args = wp_parse_args($args, array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'show_count' => 1,
			'title_li'   => '',
			'number'     => 10
		));
	}

	return $args;
}

add_filter('widget_categories_dropdown_args', 'creiden_widget_categories_dropdown_args');

/**
 * Adds the .thumbnail class when images are sent to editor
 *
 * @param string $html
 * @param int $id
 * @param string $caption
 * @param string $title
 * @param string $align
 * @param string $url
 * @param string $size
 * @param string $alt
 *
 * @return    string    Image HTML
 * @author    Konstantin Obenland
 * @since    2.0.0 - 29.08.2012
 *
 */
function creiden_image_send_to_editor($html, $id, $caption, $title, $align, $url, $size, $alt)
{
	if ($url) {
		$html = str_replace('<a ', '<a class="thumbnail" ', $html);
	} else {
		$html = str_replace('class="', 'class="thumbnail ', $html);
	}

	return $html;
}

add_filter('image_send_to_editor', 'creiden_image_send_to_editor', 10, 8);

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @return    void
 * @since    2.0.0 - 29.08.2012
 *
 * @author    WordPress.org
 */
function creiden_content_width()
{
	if (is_attachment()) {
		global $content_width;
		$content_width = 940;
	}
}


/*
 * List all users through api even if they didn't post
 */

add_filter('rest_user_query', function ($prepared_args, $request = null) {
	unset($prepared_args['has_published_posts']);

	return $prepared_args;
});

add_action('template_redirect', 'creiden_content_width');

/**
 * Returns the Theme version string
 *
 * @return    string    The Bootstrap version
 * @since    1.2.4 - 07.04.2012
 * @access    private
 *
 * @author    Konstantin Obenland
 */
function _creiden_version()
{

	if (function_exists('wp_get_theme')) {
		$theme_version = wp_get_theme()->get('Version');
	} else {
		$theme_data    = wp_get_theme(get_template_directory() . '/style.css');
		$theme_version = $theme_data['Version'];
	}

	return $theme_version;
}

/* ========================================================================================================================

  Image resize Function

  ======================================================================================================================== */

/**
 * Crops the images to the needed sizes
 *
 * @author    creiden
 * @since    1.0.0 - 06.23.2013
 * @access    private
 *    sample of usage -> add_image_size('slider-thumb', width, height, true);
 */
function creiden_resize()
{
}

add_action('init', 'creiden_resize');
/* End of file functions.php */

/* ========================================================================================================================

  Custom woocommerce actions
  ======================================================================================================================== */


add_action('woocommerce_template_single_title', 'woocommerce_template_single_title', 10);
add_action('woocommerce_template_single_rating', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_template_single_price', 'woocommerce_template_single_price', 10);
add_action('woocommerce_template_single_excerpt', 'woocommerce_template_single_excerpt', 10);
add_action('woocommerce_template_single_meta', 'woocommerce_template_single_meta', 10);
add_action('woocommerce_template_single_sharing', 'woocommerce_template_single_sharing', 10);
add_action('woocommerce_template_single_data', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_product_description_tab', 'woocommerce_product_description_tab', 10);
add_action('woocommerce_product_additional_information_tab', 'woocommerce_product_additional_information_tab', 10);
add_action('woocommerce_output_related_products', 'woocommerce_output_related_products', 10);



function add_get_file_query_var($vars)
{
	$vars[] = 'get_file';
	return $vars;
}
add_filter('query_vars', 'add_get_file_query_var');

function intercept_file_request($wp)
{
	if (!isset($wp->query_vars['get_file']))
		return;

	global $wpdb, $current_user;

	// Find attachment entry for this file in the database:
	$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid='%s'", $_SERVER['REQUEST_URI']);
	$attachment_id = $wpdb->get_var($query);

	// No attachment found. 404 error.
	if (!$attachment_id) {
		$wp->query_vars['error'] = '404';
		return;
	}

	// Get post from database
	$file_post = get_post($attachment_id);
	$file_path = get_attached_file($attachment_id);

	if (!$file_post || !$file_path || !file_exists($file_path)) {
		$wp->query_vars['error'] = '404';
		return;
	}

	// Logic for validating current user's access to this file...

	// Option A: check for user capability
	//    if( !current_user_can( 'required_capability' ) ) {
	//        $wp->query_vars['error'] = '404';
	//        return;
	//    }

	// Option B: check against current user
	//    if( $current_user->user_login == "authorized_user" ) {
	//    if( !get_current_user_id() == 1 ) {
	if (!is_user_logged_in()) {
		$wp->query_vars['error'] = '404';
		return;
	}

	// Everything checks out, user can see this file. Simulate headers and go:
	header('Content-Type: ' . $file_post->post_mime_type);
	header('Content-Dispositon: attachment; filename="' . basename($file_path) . '"');
	header('Content-Length: ' . filesize($file_path));

	echo file_get_contents($file_path);
	die(0);
}
add_action('wp', 'intercept_file_request');
// after login users will be back on the finish order page to check some cases
function redirect_admin($redirect_to, $request, $user)
{

	//is there a user to check?

	if (isset($user->roles) && is_array($user->roles)) {

		//check for non-admin users
		if (!in_array('administrator', $user->roles)) {

			$redirect_to = get_template_page_url('templates/page-finishOrder.php'); // Your redirect URL
		}
	}

	return $redirect_to;
}

add_filter('login_redirect', 'redirect_admin', 10, 3);

// remove user view action from admin users list
add_filter('user_row_actions', 'remove_row_actions', 10, 1);

function remove_row_actions($actions)
{
	unset($actions['view']);
	return $actions;
}

add_filter('woocommerce_my_account_my_orders_actions', 'remove_myaccount_orders_cancel_button', 10, 2);
function remove_myaccount_orders_cancel_button($actions, $order)
{
	unset($actions['cancel']);

	return $actions;
}


add_action( 'woocommerce_new_order', 'add_site_field_to_order' );
function add_site_field_to_order( $order_id ) {
	// action...
	if ( ! add_post_meta( $order_id, 'site', 'homefrontpumps.com', true ) ) { 
		update_post_meta ( $order_id, 'site', 'homefrontpumps.com' );
	}
}

add_action( 'user_register', 'user_add_sitemetafield', 10, 1 );
 
function user_add_sitemetafield( $user_id ) {
 	update_user_meta($user_id, 'site', 'homefrontpumps.com');
}



add_filter ( 'woocommerce_account_menu_items', 'add_additional_info_link', 40 );
function add_additional_info_link( $menu_links ){
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
		$shipping_state = get_user_meta($user_id, 'shipping_state', true);

		if ($shipping_state != 'AA' && $shipping_state != 'AE' && $shipping_state != 'AP' && $shipping_state != 'AZ' && $shipping_state != 'PA' && $shipping_state != 'WI' && $shipping_state != 'OH' && $shipping_state != 'NY') {
			$menu_links = array_slice( $menu_links, 0, 4, true ) 
			+ array( 'additional-info' => 'Additional Information' )
			+ array_slice( $menu_links, 4, NULL, true );
		}

	}
	return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'myaccount_add_endpoint' );
function myaccount_add_endpoint() {

	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'additional-info', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_additional-info_endpoint', 'jin_my_account_endpoint_content' );
function jin_my_account_endpoint_content() {

	// of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
	wc_get_template( 'myaccount/additional-info.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );

}

add_action('updated_user_meta', 'when_user_meta_updated', 10, 5);

function when_user_meta_updated( $meta_id, $object_id, $meta_key, $_meta_value ) {	
	if ($meta_key !== 'user_modified_flag' && $meta_key !== 'last_modified_fields') {
		
		update_user_meta($object_id , 'user_modified_flag', true);
		$modifled_fileds = get_user_meta($object_id, 'last_modified_fields', true);
		if (!isset($modifled_fileds) || !is_array($modifled_fileds) || empty($modifled_fileds) ) {
			$modifled_fileds = [];
		}
		$modifled_fileds[] = $meta_key;
		if (count($modifled_fileds) > 10 )  {
			$modifled_fileds = array_slice( $modifled_fileds, -10, 10, true );
		}
		update_user_meta($object_id , 'last_modified_fields', $modifled_fileds);
	}	
}

function hfp_user_has_orders()
{
    if (!is_user_logged_in()) return 0;
    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => array('wc-pending', 'wc-processing', 'wc-on-hold', 'wc-completed', 'wc-data-needed', 'wc-shipped', 'wc-delivered', 'wc-verifying-data', 'wc-wait-eligibility', 'wc-authorized', 'wc-wait-prescription', 'wc-sent-to-warehouse' ) 
    ) );

	return count($customer_orders);
}

function hfp_uploadImages($user_id, $file_id, $hash_id) {
		// Save prescription
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		$files       = $_FILES[$file_id];
		$attachments = [];
		$hashes = [];
		foreach ($files['name'] as $key => $value) {
			if ($files['name'][$key]) {
				$file          = array(
					'name'     => $files['name'][$key],
					'type'     => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error'    => $files['error'][$key],
					'size'     => $files['size'][$key]
				);
				compressImage($file['tmp_name'], $file['tmp_name'], 75);
				$_FILES        = array($file_id => $file);	
				$attachment_id = media_handle_upload($file_id, 0);

				if (is_wp_error($attachment_id)) {
					// There was an error uploading the image.
					echo "Error adding file";
				} else {
					$attachment_path               = get_the_guid($attachment_id);
					$attachments["$attachment_id"] = $attachment_path;					
				}
			}
		}

		if (!empty( $attachments)) {
			update_user_meta($user_id, $file_id, $attachments);
			foreach($attachments as $attachment_id => $attachment_path) {
				$hashes[$attachment_id] = hash_file('md5', $attachment_path);
			}
			update_user_meta($user_id, $hash_id, $hashes);
		}
}

function hfp_uploadImage($user_id, $file_id, $hash_id) {

	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');

	$files       = $_FILES[$file_id];
	$attachments = [];
	$hashes = [];
	$file          = array(
		'name'     => $files['name'],
		'type'     => $files['type'],
		'tmp_name' => $files['tmp_name'],
		'error'    => $files['error'],
		'size'     => $files['size']
	);
	$_FILES['face_file'] = $file;
	compressImage($file['tmp_name'], $file['tmp_name'], 75);
	$attachment_id = media_handle_upload($file_id, 0);

	if (is_wp_error($attachment_id)) {
		echo "Error adding file";
	} else {
		$attachment_path               = get_the_guid($attachment_id);
		$attachments["$attachment_id"] = $attachment_path;
	}


	if (!empty( $attachments)) {

		update_user_meta($user_id, $file_id, $attachments);
		foreach($attachments as $attachment_id => $attachment_path) {
			$hashes[$attachment_id] = hash_file('md5', $attachment_path);
		}
		update_user_meta($user_id, $hash_id, $hashes);
	}
}

function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
           imagejpeg($image, $destination, $quality);
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            imagepng($image, $destination, $quality / 10);
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            imagegif($image, $destination);
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
           imagejpeg($image, $destination, $quality);
    } 
     
     
    // Return compressed image 
    return $destination; 
} 

add_filter( 'wp_mail_from', 'sender_email' );
function sender_email( $original_email_address ) {
	return 'support@homefrontpumps.com';
}
add_filter( 'wp_mail_from_name', 'sender_name' );
function sender_name( $original_email_from ) {
	return 'Homefront Pumps';
}