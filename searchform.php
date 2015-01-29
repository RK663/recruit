<?php
/**
 * The template for displaying search forms in recruit
 *
 * @package recruit
 */
?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" method="get" role="search">
	<span class="screen-reader-text"><?php _e('Search for', 'recruit') ?>:</span>
	<div class="input-group">
		<input type="search" title="Search for:" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search...', 'recruit' ); ?>" class="form-control search-field" aria-describedby="search-form">
		<span class="input-group-addon">
			<input type="submit" value="<?php esc_attr_e( 'Search', 'recruit' ); ?>" class="search-submit">
		</span>
	</div>
</form>

