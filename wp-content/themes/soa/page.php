<?php get_header(); ?>
<div id="main" class="main-three">
	<div class="main-holder">
		<div id="overlay-fix">
			<?php while ( have_posts() ) : the_post(); ?>
			<div id="content">
				<div class="c1">
					<section class="parking-container generic-content-container">

						<div class="text-view">
							<span class="sub-logo"></span>
							<?php the_title('<h1>', '</h1>'); ?>
							<p class="lead h2"></p>
							<dl>
								<dt><?php _e('Published', 'soa'); ?>:&nbsp;</dt>
								<dd><?php echo get_the_date(); ?></dd>
								<dt><?php _e('Modified', 'soa'); ?>:&nbsp;</dt>
								<dd><?php echo get_the_modified_date(); ?></dd>
							</dl>
						</div>

						<div class="result-holder">
							<section class="data">
								<div class="content-holder">
									<?php the_content(); ?>
								</div>
							</section>
						</div>

					</section><!-- .parking-container .generic-content-container -->
				</div><!-- .c1 -->
			</div><!-- #content -->
			<?php endwhile; ?>
		</div><!-- #overlay-fix -->
		<aside id="sidebar">
			<?php get_sidebar() ?>
		</aside><!-- #sidebar -->
	</div><!-- .main-holder -->
</div><!-- #main .main-three -->
<?php get_footer(); ?>
