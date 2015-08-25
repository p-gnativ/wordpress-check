<div id="main" class="main-three">
	<div id="main-content">
		<div id="overlay-fix">
			<div id="content"><!-- push to article??? -->
				<div class="c1">
					<section class="parking-container generic-content-container">
						<span class="sub-logo"></span>
						<?php the_title('<h1>', '</h1>'); ?>
						<p class="lead h2"></p>
						<dl>
							<dt><?php _e('Published', 'soa'); ?>:&nbsp;</dt>
							<dd><?php echo get_the_date(); ?></dd>
							<dt><?php _e('Modified', 'soa'); ?>:&nbsp;</dt>
							<dd><?php echo get_the_modified_date(); ?></dd>
						</dl>
						<?php the_content(); ?>
					</section><!-- .parking-container .generic-content-container -->
				</div><!-- .c1 -->
			</div><!-- #content -->
		</div><!-- #overlay-fix -->
		<aside id="sidebar">
			<?php get_sidebar() ?>
		</aside><!-- #sidebar -->
	</div><!-- #main-content -->
</div><!-- #main .main-three -->
