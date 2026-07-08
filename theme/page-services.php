<?php
/** Services page — lists every service with application areas. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'Services', 'title' => 'Insulation services for every part of your home', 'lead' => 'From spray foam to blown-in, removal to replacement — no job too big or too small.' ) );
get_template_part( 'template-parts/page-hero' );

$applications = 'Attic · Ceilings · Interior & exterior walls · Floors · Crawlspace · Garage · Roof deck';
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$svc_icons = array( 'shield', 'wind', 'layers', 'sun', 'recycle', 'home' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto max-w-5xl">
		<div class="grid gap-6 md:grid-cols-2">
			<?php $i = 0; while ( $services->have_posts() ) : $services->the_post();
				$summary = get_field( 'summary' ); $icon = $svc_icons[ $i % count( $svc_icons ) ]; $i++; ?>
				<article class="card p-7" data-reveal>
					<span class="flex h-11 w-11 items-center justify-center rounded bg-accent/10 text-accent"><?php echo sdp_icon( $icon, 'h-5 w-5' ); ?></span>
					<h2 class="mt-4 text-xl font-bold"><?php the_title(); ?></h2>
					<?php if ( $summary ) : ?><p class="mt-2 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
		<div class="mt-10 rounded border border-line bg-surface p-6 text-sm text-muted" data-reveal>
			<span class="font-semibold text-ink">Where we insulate:</span> <?php echo esc_html( $applications ); ?>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
