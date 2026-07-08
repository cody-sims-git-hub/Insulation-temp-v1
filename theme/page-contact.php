<?php
/** Contact page — quote form (demo-only) + NAP + hours + map. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Contact', 'title' => 'Request your free estimate', 'lead' => 'Tell us about your project and we\'ll get right back to you. Prefer to talk? Call us during business hours.' ) );
get_template_part( 'template-parts/page-hero' );
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-5 lg:gap-16">
		<div class="lg:col-span-3" data-reveal>
			<form class="card p-7" x-data="{ sent: false }" @submit.prevent="sent = true">
				<div x-show="!sent" class="grid gap-5">
					<div class="grid gap-5 sm:grid-cols-2">
						<label class="block text-sm"><span class="font-medium">Name</span><input type="text" name="name" required class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
						<label class="block text-sm"><span class="font-medium">Phone</span><input type="tel" name="phone" required class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
					</div>
					<label class="block text-sm"><span class="font-medium">Email</span><input type="email" name="email" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></label>
					<label class="block text-sm"><span class="font-medium">Service needed</span>
						<select name="service" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none">
							<option value="">Not sure yet</option>
							<?php while ( $services->have_posts() ) : $services->the_post(); ?><option><?php the_title(); ?></option><?php endwhile; wp_reset_postdata(); ?>
						</select>
					</label>
					<label class="block text-sm"><span class="font-medium">Project details</span><textarea name="message" rows="4" class="mt-1.5 w-full rounded border border-line bg-bg px-3 py-2.5 focus:border-accent focus:outline-none"></textarea></label>
					<button type="submit" class="btn btn-primary w-full sm:w-auto">Request Free Estimate</button>
					<p class="text-xs text-muted">This is a demo form — submissions aren't delivered yet.</p>
				</div>
				<div x-show="sent" x-cloak class="flex flex-col items-center gap-3 py-10 text-center">
					<span class="flex h-12 w-12 items-center justify-center rounded-full bg-accent/10 text-accent"><?php echo sdp_icon( 'check', 'h-6 w-6' ); ?></span>
					<h2 class="text-xl font-bold">Thanks — request received</h2>
					<p class="max-w-sm text-sm text-muted">In the real site this reaches A Plus Insulation. For now, please call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( sdp_setting( 'phone' ) ); ?></a>.</p>
				</div>
			</form>
		</div>
		<aside class="lg:col-span-2" data-reveal>
			<dl class="space-y-5">
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?><div class="card p-5"><dt class="eyebrow">Call</dt><dd class="mt-2"><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="text-lg font-bold hover:text-accent"><?php echo esc_html( $ph ); ?></a></dd></div><?php endif; ?>
				<?php if ( $a = sdp_setting( 'address' ) ) : ?><div class="card p-5"><dt class="eyebrow">Visit</dt><dd class="mt-2 text-sm not-italic text-muted"><?php echo wp_kses( $a, array( 'br' => array() ) ); ?></dd><?php if ( $m = sdp_setting( 'maps_url' ) ) : ?><a href="<?php echo esc_url( $m ); ?>" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline">Directions <?php echo sdp_icon( 'arrow-up-right', 'h-3.5 w-3.5' ); ?></a><?php endif; ?></div><?php endif; ?>
				<?php if ( sdp_has_hours() ) : ?><div class="card p-5"><dt class="eyebrow">Hours</dt><dd class="mt-2 space-y-1 text-sm"><?php foreach ( sdp_hours() as $r ) : ?><div class="flex justify-between gap-4 text-muted"><span><?php echo esc_html( $r['day'] ); ?></span><span class="stat"><?php echo esc_html( $r['time'] ); ?></span></div><?php endforeach; ?></dd></div><?php endif; ?>
			</dl>
		</aside>
	</div>
</section>
<?php get_footer();
