<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package RECRUIT
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'recruit' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'recruit' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'recruit' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'recruit_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function recruit_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = (is_attachment()) ? get_post( get_post()->post_parent) : get_adjacent_post(false, '', true);
	$next     = get_adjacent_post(false, '', false);

	if (!$next && !$previous) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e('Post navigation', $GLOBALS['textdomain']); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link('<div class="nav-previous"><div class="nav-indicator">' . _x('Previous Post', 'Previous post', $GLOBALS['textdomain']) . '</div><h3>%link</h3></div>', '%title');
				next_post_link('<div class="nav-next"><div class="nav-indicator">' . _x('Next Post', 'Next post', $GLOBALS['textdomain']) . '</div><h3>%link</h3></div>', '%title');
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'recruit_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function recruit_posted_on() {
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'recruit' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}


	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf('<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s</span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
		_x('Author', $GLOBALS['textdomain']),
		esc_url(get_author_posts_url(get_the_author_meta('ID'))),
		esc_html(get_the_author())
	);

	printf('<span class="posted-on"><span class="screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x('Posted on', $GLOBALS['textdomain']),
		esc_url(get_permalink()),
		$time_string
	);

	if (!post_password_required() && (comments_open() || get_comments_number())) {
		echo '<span class="comments-link">';
		comments_popup_link( __('Leave a comment', $GLOBALS['textdomain']), __('1 Comment', $GLOBALS['textdomain']), __('% Comments', $GLOBALS['textdomain']));
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'recruit' ), '<span class="edit-link">', '</span>' );

}
endif;

if ( ! function_exists( 'recruit_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function recruit_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {

		$categories_list = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', $GLOBALS['textdomain']));
		if ($categories_list && recruit_categorized_blog()) {
			printf('<div class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</div>',
				_x('Categories', 'Used before category names.', $GLOBALS['textdomain']),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', $GLOBALS['textdomain']));
		if ($tags_list) {
			printf('<div class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</div>',
				_x('Tags', 'Used before tag names.', $GLOBALS['textdomain']),
				$tags_list
			);
		}

	}
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'recruit' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'recruit' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'recruit' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'recruit' ), get_the_date( _x( 'Y', 'yearly archives date format', 'recruit' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'recruit' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'recruit' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'recruit' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'recruit' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'recruit' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'recruit' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'recruit' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'recruit' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'recruit' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function recruit_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'recruit_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'recruit_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so recruit_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so recruit_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in recruit_categorized_blog.
 */
function recruit_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'recruit_categories' );
}
add_action( 'edit_category', 'recruit_category_transient_flusher' );
add_action( 'save_post',     'recruit_category_transient_flusher' );


// breadcumb extender function
// http://wordpress.stackexchange.com/questions/50425/show-current-navigation-path-from-menu
class recruit_breadcrumbs_extender extends Walker{

    /**
     * @see Walker::$tree_type
     * @var string
     */
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

    /**
     * @see Walker::$db_fields
     * @var array
     */
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    /**
     * delimiter for crumbs
     * @var string
     */
    var $delimiter = ' > ';

    /**
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    
    function start_el(&$output, $item, $depth = 0, $args=array(), $current_object_id = 0) {

        // Check if menu item is an ancestor of the current page
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $current_identifiers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' ); 
        $ancestor_of_current = array_intersect( $current_identifiers, $classes );     


        if( $ancestor_of_current ){
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            $is_current = in_array('current-menu-item', $classes);

            // Link tag attributes
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';


            // Add to the HTML output
            if ($is_current == true) {
            	$output .= '<li>'.$title.'</li>';
            } else {
	            $output .= '<li><a'. $attributes .' class="">'.$title.'</a></li>';
            }
        }
    }
}

//breadcumb function
function recruit_breadcrumbs() {
    global $post;
    if (!is_home() && !is_front_page()) {
	    echo '<ol class="breadcrumb">';
        echo '<li><a href="';
        echo home_url();
        echo '">';
        echo __('Home', 'recruit');
        echo '</a></li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li> ');
            if (is_single()) {
                echo '</li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {

            wp_nav_menu(array(
			    'container' => 'none',
			    'theme_location' => 'primary',
			    'walker'=> new recruit_breadcrumbs_extender(),
			    'items_wrap' => '%3$s'
			));

        }
	    echo '</ol>';
    }
} // end recruit_breadcrumbs()


/** Comments Template **/
if ( ! function_exists( 'recruit_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function recruit_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'recruit' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'recruit' ), ' ' ); ?></p>
    <?php
        break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<div id="comment-<?php comment_ID(); ?>" class="media comment-body clearfix">
			<div class="pull-left">
				<?php echo get_avatar( $comment, 50 ); ?>
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?php comment_author(); ?></h4>
				<div class="comment-metadata">
					<time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'recruit' ), get_comment_date(), get_comment_time() ); ?>
					</time><?php edit_comment_link( __( '(Edit)', 'recruit' ), ' ' ); ?>
				</div>
				<?php comment_text(); ?>
				<div class="reply-link">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		</div>

    <?php
	break;
    endswitch;
}
endif; // ends check for recruit_comment()


function recruit_post_thumbnail() {
	if (has_post_thumbnail()) {
		echo '<div class="post-thumbnail">';
		if (is_single()) {
			the_post_thumbnail('post-thumbnail', array('alt' => get_the_title()));
		} else {
			echo '<a href="'. esc_url(get_permalink()) .'" class="thumbnail">';
			the_post_thumbnail('post-thumbnail', array('alt' => get_the_title()));
			echo '</a>';
		}
		echo '</div>';
	}
}

function recruit_post_title() {
	if (!is_single()) {
		the_title(sprintf('<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h1>');
	} else {
		the_title('<h1 class="entry-title">', '</h1>');
	}
}