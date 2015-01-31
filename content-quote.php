<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * Used for both single and index/archive/search.
 *
 * @package recruit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (has_post_thumbnail()): ?>
	<div class="entry-content bg blockquote-with-bg" style="background-image: url('<?php echo recruit_post_thumbnail_url(); ?>');">
		<?php recruit_post_format_quote(); ?>
	</div><!-- .entry-content -->
	<?php else : ?>
	<div class="entry-content">
		<?php recruit_post_format_quote(); ?>
	</div><!-- .entry-content -->
	<?php endif ?>

</article><!-- #post-## -->