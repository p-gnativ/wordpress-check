<?php get_header(); ?>
<div id="main">
	<div id="main-content">
		<div id="overlay-fix">
			<?php if(have_posts()) :
				while (have_posts()) : the_post(); ?>
					<div id="content">
						<div class="c1">
							<section class="parking-container generic-content-container">
								<div class="text-view">
									<?php the_title('<h1>', '</h1>'); ?>
									<p class="lead h2"></p>
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
				<?php endwhile;
			else : ?>
				test
				//get_template_part('content', 'none');
			<?php endif; ?>
		</div><!-- #overlay-fix -->
	</div><!-- #main-content -->
</div><!-- #main -->
<?php get_footer(); ?>