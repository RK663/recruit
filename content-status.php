<?php
/**
 * The template for displaying posts in the Status post format
 *
 * Used for both single and index/archive/search.
 *
 * @package recruit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (has_post_thumbnail()): ?>
	<div class="entry-content bg status-with-bg" style="background-image: url('<?php echo recruit_post_thumbnail_url(); ?>');">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<?php endif ?>

</article><!-- #post-## -->