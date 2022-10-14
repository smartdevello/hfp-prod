<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

get_header(); ?>

<div class="container">
	<div class="row">
		
		<section id="primary" class="col-sm-9">
			<?php tha_content_before(); ?>
			<div id="content" role="main">
				<?php tha_content_top();

				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( '/partials/content', get_post_format() );
					}
					creiden_content_nav( 'nav-below' );
				}
				else {
					get_template_part( '/partials/content', 'not-found' );
				}

				tha_content_bottom(); ?>
			</div><!-- #content -->
			<?php tha_content_after(); ?>
		</section><!-- #primary -->
		
		<aside class="col-sm-3">
			<?php get_sidebar(); ?>
		</aside>
		
	</div>
</div>

<?php
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/index.php */