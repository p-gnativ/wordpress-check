<?php
if(has_nav_menu('side')) : ?>
	<div id="menu-wrapper">
		<div id="menu-scroller">
		<?php
			// side navigation menu.
			wp_nav_menu( array(
				'menu_class' => 'nav-menu',
				'container' => 'none',
				'theme_location' => 'side',
				'menu_id' => 'mainmenu',
			) );
		?>
		</div>
	</div>
<?php endif; ?>