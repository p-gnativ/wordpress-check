<?php get_header(); ?>
<div style="display:none">
<div id="main">
	<div id="main-content">
		<div id="overlay-fix">
			<div id="content">
				main
			</div><!-- #content -->
		</div><!-- #overlay-fix -->
	</div><!-- #main-content -->
</div><!-- #main -->

<div id="main" class="main-three">
	<div id="main-content">
		<div id="overlay-fix">
			<div id="content"><!-- push to article??? -->
				<div class="c1">
					<section class="parking-container generic-content-container">
						main and menu
					</section><!-- .parking-container .generic-content-container -->
				</div><!-- .c1 -->
			</div><!-- #content -->
		</div><!-- #overlay-fix -->
		<aside id="sidebar">
			sidebar
		</aside><!-- #sidebar -->
	</div><!-- #main-content -->
</div><!-- #main .main-three -->
</div>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php

			// Start the loop.
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
			get_template_part('template-inc/content', get_post_format());
//var_dump(get_template_part('template-inc/content', get_post_format()));

				//get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			/*the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );*/

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
