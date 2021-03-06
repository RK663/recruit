<?php
/**
 * The template for displaying all single posts.
 *
 * @package RECRUIT
 */

get_header(); ?>

	<div id="recruit-header" class="col-sm-12">
		<div id="breadcrumb">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php recruit_breadcrumbs(); ?>			
		</div>
	</div>

	<div id="primary" class="content-area col-sm-8">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<?php recruit_post_navigation(); ?>

			<?php
			if (get_the_author_meta('description')) {
				get_template_part('author-bio');
			}
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
