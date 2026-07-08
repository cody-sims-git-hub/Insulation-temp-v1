<?php
/** About page — story + values, how we work, practical details, then CTA. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array( 'eyebrow' => 'About', 'title' => 'Your Local Insulation Experts in Marianna, Florida', 'lead' => 'Family-run since 2006. A Plus Insulation has spent two decades keeping Jackson County homes comfortable and efficient — one honest job at a time.' ) );
get_template_part( 'template-parts/page-hero' );
?>
<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-5xl gap-12 lg:grid-cols-3">
		<div class="lg:col-span-2 prose-sdp" data-reveal>
			<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
		</div>
		<aside class="space-y-4" data-reveal>
			<img src="<?php echo esc_url( SDP_URI . '/assets/photos/worker.jpg' ); ?>" alt="A Plus Insulation crew member applying spray foam insulation" class="w-full rounded border-2 border-line object-cover" style="aspect-ratio: 4 / 5;" loading="lazy">
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

<section class="border-y-2 border-line bg-surface px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto grid max-w-5xl gap-10 lg:grid-cols-2 lg:gap-16">
		<div data-reveal>
			<span class="eyebrow">Our story</span>
			<h2 class="marker mt-3 text-2xl font-black uppercase tracking-tight sm:text-3xl">20 years, one county</h2>
			<p class="mt-6 text-muted">A Plus Insulation started in 2006 with a simple idea: do the work right, quote a fair number, and let the results speak for themselves. Two decades later we're still family-run and still working out of our home base on Hwy 90 in Marianna — the same county we started in.</p>
			<p class="mt-4 text-muted">That matters more than it sounds. When your insulation contractor lives where you work, the job isn't done when the invoice is paid. We run into our customers at the grocery store and the ball field, and every attic we insulate carries our name for the next twenty years.</p>
		</div>
		<div class="grid content-start gap-4 sm:grid-cols-2" data-reveal>
			<div class="card p-6">
				<span class="stat text-4xl text-cta">2006</span>
				<p class="mt-2 text-sm font-bold uppercase tracking-wide">The year we started</p>
				<p class="mt-1 text-sm text-muted">Insulating Panhandle homes ever since.</p>
			</div>
			<div class="card p-6">
				<span class="stat text-4xl text-cta">20</span>
				<p class="mt-2 text-sm font-bold uppercase tracking-wide">Years family-run</p>
				<p class="mt-1 text-sm text-muted">Same family, same standards, no franchises.</p>
			</div>
			<div class="card p-6 sm:col-span-2">
				<span class="text-accent"><?php echo sdp_icon( 'pin', 'h-6 w-6' ); ?></span>
				<p class="mt-2 text-sm font-bold uppercase tracking-wide">Home base: Hwy 90, Marianna</p>
				<p class="mt-1 text-sm text-muted">Right in the middle of Jackson County — most estimates are a short drive from the shop.</p>
			</div>
		</div>
	</div>
</section>

<section class="px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto max-w-5xl">
		<span class="eyebrow" data-reveal>How we work</span>
		<h2 class="marker mt-3 text-2xl font-black uppercase tracking-tight sm:text-3xl" data-reveal>Four commitments on every job</h2>
		<div class="mt-10 grid gap-4 sm:grid-cols-2">
			<?php
			$commitments = array(
				array( 't' => 'Show up when we say', 'd' => 'You get a time, not a four-hour window. If anything changes, you hear it from us first.' ),
				array( 't' => 'Explain options in plain English', 'd' => 'Spray foam, blown-in, batts — we lay out what each one does for your house and what it costs, without the jargon.' ),
				array( 't' => 'Flat written numbers', 'd' => 'Your estimate is itemized and in writing. The number we quote is the number you pay.' ),
				array( 't' => 'Leave it cleaner than we found it', 'd' => 'We haul off the mess, old insulation included. You should only notice the comfort, not the job.' ),
			);
			foreach ( $commitments as $c ) : ?>
				<div class="card flex gap-4 p-6" data-reveal>
					<span class="mt-0.5 shrink-0 text-accent"><?php echo sdp_icon( 'check', 'h-6 w-6' ); ?></span>
					<div>
						<h3 class="font-bold"><?php echo esc_html( $c['t'] ); ?></h3>
						<p class="mt-1 text-sm text-muted"><?php echo esc_html( $c['d'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="bg-accent px-5 py-12 text-accent-ink lg:px-8 lg:py-14">
	<div class="mx-auto grid max-w-5xl gap-8 sm:grid-cols-3">
		<?php
		$details = array(
			array( 't' => 'Cash & all major cards', 'd' => 'Pay however works for you — cash and all major cards accepted.' ),
			array( 't' => 'ASL-proficient', 'd' => 'Deaf and hard-of-hearing homeowners are welcome to work with us directly in American Sign Language.' ),
			array( 't' => 'Free estimates', 'd' => 'Every estimate is free, written, and itemized — no pressure, no obligation.' ),
		);
		foreach ( $details as $d ) : ?>
			<div class="flex gap-3" data-reveal>
				<span class="mt-0.5 shrink-0 text-cta"><?php echo sdp_icon( 'check', 'h-5 w-5' ); ?></span>
				<div>
					<h3 class="font-bold uppercase tracking-wide text-sm"><?php echo esc_html( $d['t'] ); ?></h3>
					<p class="mt-1 text-sm opacity-80"><?php echo esc_html( $d['d'] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
