<?php
/** Service Area page — town-by-town coverage + map + CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Service Area', 'title' => 'Insulation Services Across Jackson County & the NW Florida Panhandle', 'lead' => 'Based on Hwy 90 in Marianna, we cover Jackson County and the surrounding Panhandle. If your town is nearby and not listed, just call.' ) );
get_template_part( 'template-parts/page-hero' );
$area = array(
	array( 't' => 'Marianna', 'd' => 'Home base. Our shop sits on Hwy 90 in the middle of town, so most Marianna estimates happen fast.' ),
	array( 't' => 'Sneads & Grand Ridge', 'd' => 'East Jackson County, out toward the river — a straight run down US-90 from the shop.' ),
	array( 't' => 'Graceville & Campbellton', 'd' => 'North toward the Alabama line. We cover the whole top of the county.' ),
	array( 't' => 'Chipley & Bonifay', 'd' => 'West into Washington and Holmes counties — Panhandle neighbors we work in regularly.' ),
	array( 't' => 'Alford & Cottondale', 'd' => 'Along US-231 just south and west of Marianna — some of our shortest drives.' ),
	array( 't' => 'Malone & Greenwood', 'd' => 'North county farm country. Older homes up this way often have the most to gain from an attic top-up.' ),
);
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:gap-16">
		<div data-reveal>
			<span class="eyebrow">Where we work</span>
			<h2 class="marker mt-3 text-2xl font-black uppercase tracking-tight sm:text-3xl">Town by town</h2>
			<dl class="mt-8 grid gap-4">
				<?php foreach ( $area as $town ) : ?>
					<div class="card p-5">
						<dt class="flex items-center gap-2 font-bold"><span class="text-accent"><?php echo sdp_icon( 'pin', 'h-4 w-4' ); ?></span><?php echo esc_html( $town['t'] ); ?></dt>
						<dd class="mt-1.5 text-sm text-muted"><?php echo esc_html( $town['d'] ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
			<p class="mt-8 text-sm text-muted">Serving all of Jackson County and the surrounding Panhandle, including nearby communities like Cypress.</p>
		</div>
		<div class="space-y-6" data-reveal>
			<div class="overflow-hidden rounded border-2 border-line">
				<iframe title="Service area map" width="100%" height="380" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Marianna,+FL+32446&output=embed"></iframe>
			</div>
			<div class="card border-ink bg-surface p-7">
				<h3 class="text-xl font-black uppercase tracking-tight">Not sure if we reach you?</h3>
				<p class="mt-3 text-sm text-muted">If your town is close to the map and not on the list, odds are we cover it. Call and we'll tell you in thirty seconds — and set up your free estimate while we're at it.</p>
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?>
					<a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn btn-primary mt-5 w-full sm:w-auto"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> Call <?php echo esc_html( $ph ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
