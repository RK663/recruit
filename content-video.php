<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package recruit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		
		<?php recruit_post_title(); ?>

		<?php if ('post' == get_post_type() && is_single()) : ?>
		<div class="entry-meta">
			<?php recruit_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'recruit' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'recruit' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ('post' == get_post_type() && !is_single()) : ?>
	<div class="entry-meta">
		<?php recruit_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<?php if (is_single()) : ?>
	<footer class="entry-footer">
		<?php recruit_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->