<?php
/** About page — story + values, then the page body, then CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'About', 'title' => 'Local, family-run, insulating Jackson County since 2006', 'lead' => 'A Plus Insulation has spent nearly two decades keeping Marianna-area homes comfortable and efficient — one honest job at a time.' ) );
get_template_part( 'template-parts/page-hero' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-5xl gap-12 lg:grid-cols-3">
		<div class="lg:col-span-2 prose-sdp" data-reveal>
			<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
		</div>
		<aside class="space-y-4" data-reveal>
			<img src="<?php echo esc_url( SDP_URI . '/assets/photos/worker.jpg' ); ?>" alt="A Plus Insulation crew member applying spray foam insulation" class="w-full rounded-lg border border-line object-cover shadow-sm" style="aspect-ratio: 4 / 5;" loading="lazy">
			<?php
			$vals = array(
				array( 'i' => 'shield', 't' => 'Licensed & insured', 'd' => 'Fully covered so you never carry the risk.' ),
				array( 'i' => 'home',   't' => 'No job too big or too small', 'd' => 'From a single attic to a whole rebuild.' ),
				array( 'i' => 'leaf',   't' => 'Efficiency first', 'd' => 'Right materials, right R-value for our climate.' ),
			);
			foreach ( $vals as $v ) : ?>
				<div class="card p-5">
					<span class="text-accent"><?php echo sdp_icon( $v['i'], 'h-6 w-6' ); ?></span>
					<h3 class="mt-3 font-bold"><?php echo esc_html( $v['t'] ); ?></h3>
					<p class="mt-1 text-sm text-muted"><?php echo esc_html( $v['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</aside>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
