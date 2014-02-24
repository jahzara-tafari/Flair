<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sz
 */

if ( ! function_exists( 'sz_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function sz_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation row" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'sennzaversion3' ); ?></h1>
		<div class="nav-links large-12 columns">

			<?php if ( function_exists( 'wp_pagenavi' ) ) { ?>
				<?php wp_pagenavi(); ?>
			<?php } else { ?>

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'sennzaversion3' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'sennzaversion3' ) ); ?></div>
				<?php endif; ?>
			<?php } ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif; // sz_paging_nav

if ( ! function_exists( 'sz_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function sz_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation row" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'sennzaversion3' ); ?></h1>
		<div class="nav-links large-12 columns">
			<?php if ( function_exists( 'wp_pagenavi' ) ) { ?>
				<?php wp_pagenavi(); ?>
			<?php } else { ?>
				<?php previous_post_link( '%link', _x( '<span class="page-left">%title</span>', 'Previous post link', 'sennzaversion3' ) ); ?>
				<?php next_post_link(     '%link', _x( '<span class="page-right">%title</span>', 'Next post link',     'sennzaversion3' ) ); ?>
			<?php } ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif; // sz_post_nav

if ( ! function_exists( 'sz_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sz_posted_on() {

	if ( ! post_password_required() && ( '0' != get_comments_number() ) ) {
		if ( get_comments_number() > '10' ) {
			echo "<span class='comment-count more-than-10-comments'><a href='" . get_comments_link() ."' title='Leave a comment'>" . get_comments_number() . "</a></span>";
		}
		else {
			echo "<span class='comment-count'><a href='" . get_comments_link() ."' title='Leave a comment'>" . get_comments_number() . "</a></span>";
		}
	}

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">This entry was posted in %1$s</span><span class="byline"> by %2$s</span>', 'sennzaversion3' ),
		sprintf( '%1$s',
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function sz_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so _s_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so _s_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in sz_categorized_blog
 */
function sz_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'sz_category_transient_flusher' );
add_action( 'save_post',     'sz_category_transient_flusher' );