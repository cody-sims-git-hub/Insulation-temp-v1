<?php
/** Service Area page — town list + map + CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Service Area', 'title' => 'Proudly serving Marianna & Jackson County', 'lead' => 'Based on Hwy 90 in Marianna, we cover the surrounding Florida Panhandle. If your town is nearby and not listed, just call.' ) );
get_template_part( 'template-parts/page-hero' );
$area = array( 'Marianna', 'Sneads', 'Graceville', 'Chipley', 'Alford', 'Bonifay', 'Cottondale', 'Grand Ridge', 'Malone', 'Cypress', 'Greenwood', 'Campbellton' );
$maps = sdp_setting( 'maps_url' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:gap-16">
		<div data-reveal>
			<h2 class="text-2xl font-bold">Towns we cover</h2>
			<div class="mt-6 flex flex-wrap gap-3">
				<?php foreach ( $area as $town ) : ?>
					<span class="inline-flex items-center gap-2 rounded border border-line bg-surface px-4 py-2 text-sm font-medium"><span class="text-accent"><?php echo sdp_icon( 'pin', 'h-4 w-4' ); ?></span><?php echo esc_html( $town ); ?></span>
				<?php endforeach; ?>
			</div>
			<p class="mt-8 text-sm text-muted">Serving all of Jackson County and the surrounding Panhandle. Call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( sdp_setting( 'phone' ) ); ?></a> to confirm your address.</p>
		</div>
		<div class="overflow-hidden rounded border border-line" data-reveal>
			<iframe title="Service area map" width="100%" height="380" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Marianna,+FL+32446&output=embed"></iframe>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
