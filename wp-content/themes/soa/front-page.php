<?php get_header(); ?>
<?php
	$theme_mod = sanitize_title(wp_get_theme());
?>
<div id="main">
	<div id="main-content">
		<div id="overlay-fix">
			<?php if(have_posts()) :
				while(have_posts()) : the_post(); ?>
					<div id="content">

						<?php if(sidebar_exist_and_active('home-top-widget')){ ?>
							<section class="home-picture">
								<?php dynamic_sidebar('home-top-widget'); ?>
							</section>
						<?php }; ?>

						<?php if(sidebar_exist_and_active('home-second-widget')){ ?>
							<section class="home-container">
								<?php
									$all_sidebars = wp_get_sidebars_widgets();
									$total_second_widgets = count($all_sidebars['home-second-widget']);
									$limit_second_allowed = 5;
									if($total_second_widgets > $limit_second_allowed){
										echo '<p>Your ' . $total_second_widgets . ' added widgets goes over the allowed limit: <strong>' . $limit_allowed . '</strong></p>';
									}else{
										echo '<ul class="boxes-list boxes-' . $total_second_widgets . '">';
										dynamic_sidebar('home-second-widget');
										echo '</ul>';
									};
								?>
							</section>
						<?php }; ?>

						<?php if(sidebar_exist_and_active('home-banner-widget')){ ?>
							<section class="home-container">
								<?php
									//$all_sidebars = wp_get_sidebars_widgets();
									$total_banner_widgets = count($all_sidebars['home-banner-widget']);
									$limit_banner_allowed = 5;
									if($total_banner_widgets > $limit_banner_allowed){
										echo '<p>Your ' . $total_banner_widgets . ' added widgets goes over the allowed limit: <strong>' . $limit_allowed . '</strong></p>';
									}else{
										echo '<ul class="boxes-list boxes-' . $total_banner_widgets . '">';
										dynamic_sidebar('home-banner-widget');
										echo '</ul>';
									};
								?>
							</section>
						<?php }; ?>
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