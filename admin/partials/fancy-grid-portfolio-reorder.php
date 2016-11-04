<?php
$args = array(
	'post_type'              => 'portfolio_item',
	'order_by'               => 'menu_order',
	'order'                  => 'ASC',
	'post_status'            => 'publish',
	'no_found_rows'          => true,
	'update_post_term_cache' => false,
	'post_per_page'          => 50
);

$portfolio = new WP_Query( $args );

?>
<div id="fgp-portfolio-sort" class="wrap">
	<h2><?php esc_html_e( 'Sort Portfolio Items', 'fgp-domain' ); ?>
		<img class="loading" src="<?php echo esc_url( admin_url() . '/images/loading.gif' ) ?>">
	</h2>
	<p class="description">Just Drag and Drop your items in the desired order, and it will display in the exact
		same order on the front end.</p>
	<div class="order-save-msg updated"><?php esc_html_e( 'Listing Order Saved', 'fgp-domain' ); ?></div>
	<div class="order-save-err error"><?php esc_html_e( 'Something Went Wrong', 'fgp-domain' ); ?></div>

	<?php if ( $portfolio->have_posts() ): ?>

		<ul id="portfolio-sort-list">
			<?php while ( $portfolio->have_posts() ): $portfolio->the_post(); ?>
				<li id="<?php esc_attr( the_ID() ); ?>">
					<h2><?php esc_html_e( the_title() ); ?></h2>

					<?php
					if ( has_post_thumbnail() ) {
						get_the_post_thumbnail( 'fgp_thumbnail' );
					}
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fgp_thumbnail' );
					?>

					<img src="<?php echo $thumb[0]; ?>">
				</li>
			<?php endwhile; ?>
		</ul>

	<?php else: ?>

		<p><?php esc_html_e( 'No Portfolio Items to List' ); ?></p>

	<?php endif; ?>

</div>