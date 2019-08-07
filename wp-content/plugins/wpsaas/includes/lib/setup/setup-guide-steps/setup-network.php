<p><?php _e('Multisite is a WordPress feature which allows users to create a network of sites on a single WordPress installation. Available since WordPress version 3.0, Multisite is a continuation of WPMU or WordPress Multiuser project. WordPress MultiUser project was discontinued and its features were included into WordPress core.', 'wpsaas'); ?></p>

<h3>1. <?php _e('Setting WP_ALLOW_MULTISITE to true', 'wp-ultimo'); ?></h3>

<p><?php _e("First we need to let WordPress know it has to enable multisite functions. This should be done by adding <code>define( 'WP_ALLOW_MULTISITE', true );</code> to your <code>wp-config.php</code> file.", 'wpsaas'); ?></p>

<p style="border-radius: 3px; border: solid 1px #ccc; padding: 10px; display: block;"><?php _e("<strong>IMPORTANT:</strong> Be sure to add the <code>define( 'WP_ALLOW_MULTISITE', true );</code> code <strong>ABOVE</strong> the <code>/* That's all, stop editing! Happy blogging. */</code> line of your <code>wp-config.php</code> file. If it doesn't say that anywhere, then add the line somewhere above the first line that begins with <code>require</code> or <code>include</code>.", 'wp-ultimo'); ?>

<h3>2. <?php _e('WordPress Network Setup', 'wp-ultimo'); ?></h3>

<p><?php _e("Now you need to start WP Network setup. The previous step enables the <strong>Network Setup</strong> item in your <strong>Tools</strong> menu. Use that menu item to go to the <strong>Network Setup</strong> screen.", 'wpsaas'); ?></p>

<p style="border-radius: 3px; border: solid 1px #ccc; padding: 10px; display: block;"><?php _e("<strong>IMPORTANT:</strong> If you have a problem or a question regarding the network setup please consult the official WordPress guide by following <a href=\"https://codex.wordpress.org/Create_A_Network#Installing_a_Network\" target=\"_blank\">this link</a>", 'wp-ultimo'); ?>