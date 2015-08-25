<?php

if(has_nav_menu('side')) : ?>
	<div id="secondary" class="secondary">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php
				// side navigation menu.
				wp_nav_menu( array(
					'menu_class' => 'nav-menu',
					'theme_location' => 'side',
				) );
			?>
		</nav>
	</div>

<?php endif; ?>
