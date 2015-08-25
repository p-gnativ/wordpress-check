<?php
	get_header();
?>
<section class="parking-container generic-content-container">
<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>
	<span class="sub-logo"></span>
	<div class="text-view">
		<?php the_title('<h1>', '</h1>'); ?>
		<p class="lead h2"></p>
		<dl>
			<dt><?php _e('Published', 'as-text-domain'); ?>:&nbsp;</dt>
			<dd><?php echo get_the_date(); ?></dd>
			<dt><?php _e('Modified', 'as-text-domain'); ?>:&nbsp;</dt>
			<dd><?php echo get_the_modified_date(); ?></dd>
		</dl>
<?php the_content(); ?>
		<?php
		echo get_the_content();
		//var_dump($post);
		?>
	</div>
</section>