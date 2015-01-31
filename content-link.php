<?php
/**
 * The template for displaying link post formats
 *
 * Used for both single and index/archive/search.
 *
 * @package recruit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php recruit_post_format_link(); ?>
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