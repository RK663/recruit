<?php
/**
 * The template for displaying Author bios
 *
 * @package RECRUIT
 */
?>

<div class="author-info">
	<h4 class="author-heading"><?php _e( 'Published by', 'recruit' ); ?></h4>
	<div class="author-avatar">
		<?php echo get_avatar(get_the_author_meta('user_email'), 50); ?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="author-title"><?php echo get_the_author(); ?></h3>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
		</p><!-- .author-bio -->

		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php printf( __( 'View all posts by %s', 'recruit' ), get_the_author() ); ?>
		</a>
		<div class="author-links"></div>

	</div><!-- .author-description -->
</div><!-- .author-info -->
