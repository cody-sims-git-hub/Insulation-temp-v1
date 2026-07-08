<?php
/**
 * A Plus Insulation — front page. Trades Workhorse (warmed-up flat) long-scroll.
 * Solid color bands: paper → charcoal → surface → paper → charcoal → pine → paper …
 * Data comes from the CMS (Site Settings + Service / Testimonial CPTs);
 * marketing copy is owned by this template per the 2026-07-07 redesign plan.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$cta_url   = sdp_setting( 'cta_url', home_url( '/contact/' ) );
$cta_label = sdp_setting( 'cta_label', 'Get My Free Estimate' );
$phone     = sdp_setting( 'phone' );
$photos    = SDP_URI . '/assets/photos';
$area      = array( 'Marianna', 'Sneads', 'Graceville', 'Chipley', 'Alford', 'Bonifay', 'Cottondale', 'Grand Ridge', 'Malone', 'Cypress' );
?>

<?php /* ===================== 1. HERO (paper) ===================== */ ?>
<section class="border-b-2 border-line px-5 pb-14 pt-32 lg:px-8 lg:pb-20 lg:pt-40">
	<div class="mx-auto grid max-w-6xl items-center gap-10 lg:grid-cols-2 lg:gap-16">
		<div>
			<span class="eyebrow" data-reveal>Insulation Contractor · Marianna, FL</span>
			<h1 class="marker mt-4 text-4xl font-black uppercase leading-none tracking-tight sm:text-5xl" data-reveal>Insulation Contractor Serving Marianna &amp; Jackson County, FL</h1>
			<p class="mt-6 max-w-xl text-lg leading-relaxed text-muted" data-reveal>Family-run since 2006. Spray foam, blown-in, batt &amp; roll, radiant barrier, removal and replacement &mdash; free estimates, honest numbers, no job too big or too small.</p>
			<div class="mt-7 flex flex-wrap gap-2" data-reveal>
				<span class="inline-flex items-center gap-1.5 border-2 border-line bg-bg px-3 py-1.5 text-xs font-bold uppercase tracking-wide"><span class="text-cta"><?php echo sdp_icon( 'star', 'h-3.5 w-3.5 fill-current' ); ?></span> Est. 2006</span>
				<span class="inline-flex items-center border-2 border-line bg-bg px-3 py-1.5 text-xs font-bold uppercase tracking-wide">Licensed &amp; Insured</span>
				<span class="inline-flex items-center border-2 border-line bg-bg px-3 py-1.5 text-xs font-bold uppercase tracking-wide">Free Estimates</span>
			</div>
			<div class="mt-8 flex flex-col gap-3 sm:flex-row" data-reveal>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?> <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
				<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn btn-ghost"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $phone ); ?></a><?php endif; ?>
			</div>
		</div>
		<div class="border-2 border-line" data-reveal>
			<img src="<?php echo esc_url( $photos . '/fleet.jpg' ); ?>" alt="A Plus Insulation service trucks on a Florida Panhandle job site" class="w-full object-cover" width="2048" height="1482" loading="eager">
		</div>
	</div>
</section>

<?php /* ================== 2. STAT BAND (charcoal) ================== */ ?>
<section class="bg-ink px-5 py-14 text-bg lg:px-8 lg:py-16">
	<div class="mx-auto grid max-w-6xl grid-cols-2 gap-x-6 gap-y-10 md:grid-cols-4">
		<?php
		$stats = array(
			array( 'n' => '20',   'l' => 'years insulating the Panhandle' ),
			array( 'n' => '~15%', 'l' => 'avg. heating & cooling savings from air sealing + insulation (ENERGY STAR)' ),
			array( 'n' => 'R-38', 'l' => 'recommended attic target for NW Florida' ),
			array( 'n' => '$0',   'l' => 'for an estimate — free, no obligation' ),
		);
		foreach ( $stats as $s ) : ?>
			<div data-reveal>
				<p class="stat text-4xl text-cta sm:text-5xl"><?php echo esc_html( $s['n'] ); ?></p>
				<p class="mt-2 text-sm leading-relaxed text-bg/70"><?php echo esc_html( $s['l'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php /* ================== 3. PROBLEM (surface) ================== */ ?>
<section class="border-b-2 border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:items-center lg:gap-20">
		<div data-reveal>
			<span class="eyebrow">The problem</span>
			<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">Why Panhandle power bills run high</h2>
			<p class="mt-6 leading-relaxed text-muted">On a July afternoon, an under-insulated attic here can top 130&deg;F. That heat radiates down through thin insulation, leaks in around ducts and can lights, and bakes the rooms below &mdash; so the AC runs all day and the bill climbs anyway. Air sealing plus the right insulation depth breaks the cycle.</p>
			<ul class="mt-7 space-y-3">
				<?php foreach ( array( 'Lower cooling bills all summer', 'Even, comfortable temperatures room to room', 'Less strain — and longer life — for your AC', 'A quieter, less humid, healthier home' ) as $point ) : ?>
					<li class="flex items-start gap-3 text-sm"><span class="mt-0.5 text-accent"><?php echo sdp_icon( 'check', 'h-5 w-5' ); ?></span><span><?php echo esc_html( $point ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="border-2 border-line" data-reveal>
			<img src="<?php echo esc_url( $photos . '/attic.jpg' ); ?>" alt="Spray foam insulation covering an attic roof deck in a Jackson County home" class="w-full object-cover" loading="lazy">
		</div>
	</div>
</section>

<?php /* ================== 4. SERVICES (paper) ================== */ ?>
<?php
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $services->have_posts() ) :
	$svc_icons   = array( 'shield', 'wind', 'layers', 'sun', 'recycle', 'home' );
	$svc_anchors = array( 'spray-foam', 'blown-in', 'batt-roll', 'radiant-barrier', 'removal', 'replacement' );
	$i = 0; ?>
	<section id="services" class="scroll-mt-20 px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">What we do</span>
				<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">Whole-home insulation, done right</h2>
			</div>
			<div class="mt-12 grid auto-rows-fr gap-4 sm:grid-cols-2 lg:grid-cols-3">
				<?php while ( $services->have_posts() ) : $services->the_post();
					$summary = get_field( 'summary' );
					$icon    = $svc_icons[ $i % count( $svc_icons ) ];
					$anchor  = isset( $svc_anchors[ $i ] ) ? $svc_anchors[ $i ] : $svc_anchors[0];
					$i++; ?>
					<article class="flex flex-col border-2 border-line bg-surface p-6" data-reveal>
						<span class="flex h-11 w-11 items-center justify-center border-2 border-line bg-bg text-accent"><?php echo sdp_icon( $icon, 'h-5 w-5' ); ?></span>
						<h3 class="mt-4 text-xl font-bold"><?php the_title(); ?></h3>
						<?php if ( $summary ) : ?><p class="mt-2 flex-1 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
						<a href="<?php echo esc_url( home_url( '/services/#' . $anchor ) ); ?>" class="mt-4 inline-flex items-center gap-1.5 font-display text-sm font-bold uppercase tracking-wide text-accent">Learn more <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<div class="mt-10" data-reveal><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="inline-flex items-center gap-1.5 font-display font-bold uppercase tracking-wide text-accent">All services <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a></div>
		</div>
	</section>
<?php endif; ?>

<?php /* ================== 5. PROCESS (charcoal) ================== */ ?>
<section class="bg-ink px-5 py-20 text-bg lg:px-8 lg:py-28">
	<div class="mx-auto max-w-6xl">
		<div class="max-w-2xl" data-reveal>
			<span class="eyebrow text-bg/60">How it works</span>
			<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">What happens when you call</h2>
		</div>
		<div class="mt-12 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
			<?php
			$steps = array(
				array( 'n' => '01', 't' => 'Call or send the form',   'd' => 'You reach us, not a call center. Same or next business day, we set a time.' ),
				array( 'n' => '02', 't' => 'Free attic assessment',   'd' => 'We measure what you have — depth, condition, air leaks — and show you photos of what we find.' ),
				array( 'n' => '03', 't' => 'A written, honest number', 'd' => 'Flat pricing, material options explained, no pressure. The estimate is yours either way.' ),
				array( 'n' => '04', 't' => 'Install day',             'd' => 'Most attics are done in a day. We clean up, haul off the mess, and you feel the difference the first hot afternoon.' ),
			);
			foreach ( $steps as $step ) : ?>
				<div data-reveal>
					<p class="stat text-4xl text-cta sm:text-5xl"><?php echo esc_html( $step['n'] ); ?></p>
					<h3 class="mt-4 text-lg font-bold"><?php echo esc_html( $step['t'] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-bg/70"><?php echo esc_html( $step['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php /* ================== 6. MONEY (pine) ================== */ ?>
<section class="bg-accent px-5 py-20 text-accent-ink lg:px-8 lg:py-28">
	<div class="mx-auto max-w-4xl">
		<div class="max-w-2xl" data-reveal>
			<span class="eyebrow text-accent-ink/70">Pricing</span>
			<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">Straight talk about cost</h2>
			<p class="mt-6 leading-relaxed text-accent-ink/80">Nobody should have to book an appointment just to learn what insulation runs. Typical installed ranges in our area:</p>
		</div>
		<dl class="mt-10 divide-y-2 divide-accent-ink/25 border-y-2 border-accent-ink/25" data-reveal>
			<?php
			$costs = array(
				array( 's' => 'Blown-in attic',  'p' => '$1.00–$2.50/sq ft' ),
				array( 's' => 'Batt & roll',     'p' => '$1.00–$3.00/sq ft' ),
				array( 's' => 'Spray foam',      'p' => '$3.00–$7.00/sq ft' ),
				array( 's' => 'Radiant barrier', 'p' => '$1.00–$2.00/sq ft' ),
				array( 's' => 'Removal',         'p' => '$1.00–$2.00/sq ft' ),
			);
			foreach ( $costs as $row ) : ?>
				<div class="flex flex-wrap items-baseline justify-between gap-x-6 gap-y-1 py-4">
					<dt class="font-display font-bold"><?php echo esc_html( $row['s'] ); ?></dt>
					<dd class="stat text-lg sm:text-xl"><?php echo esc_html( $row['p'] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
		<p class="mt-5 text-sm text-accent-ink/80" data-reveal>Typical ranges for our area &mdash; every home differs. Your written estimate is free.</p>
		<p class="mt-6 max-w-2xl leading-relaxed" data-reveal>Bigger job than the budget? We&rsquo;ll scope it in phases &mdash; attic first, where the payback is fastest. We take cash and all major cards.</p>
	</div>
</section>

<?php /* ================== 7. JOBS GALLERY (paper) ================== */ ?>
<section class="px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto max-w-6xl">
		<div class="max-w-2xl" data-reveal>
			<span class="eyebrow">Our work</span>
			<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">Real jobs across the Panhandle</h2>
		</div>
		<div class="mt-10 grid grid-cols-2 gap-4 lg:grid-cols-4" data-reveal>
			<?php
			$gallery = array(
				array( 'f' => 'attic.jpg',     'c' => 'Spray foam attic — Marianna',        'a' => 'Spray foam insulation covering an attic roof deck in Marianna, FL' ),
				array( 'f' => 'worker.jpg',    'c' => 'Crew at work — Jackson County',      'a' => 'A Plus Insulation crew member applying spray foam insulation on a Jackson County job' ),
				array( 'f' => 'materials.jpg', 'c' => 'Materials staged — Marianna',        'a' => 'Fiberglass insulation materials staged and ready for installation in Marianna' ),
				array( 'f' => 'jobsite.jpg',   'c' => 'On site — Hwy 90, Marianna',         'a' => 'A Plus Insulation truck and equipment on a job site along Hwy 90 in Marianna' ),
			);
			foreach ( $gallery as $g ) : ?>
				<figure class="flex flex-col border-2 border-line bg-bg">
					<img src="<?php echo esc_url( $photos . '/' . $g['f'] ); ?>" alt="<?php echo esc_attr( $g['a'] ); ?>" class="w-full object-cover" style="aspect-ratio: 4 / 5;" loading="lazy">
					<figcaption class="border-t-2 border-line px-3 py-2.5 text-xs font-bold uppercase tracking-wide text-muted"><?php echo esc_html( $g['c'] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php /* ================== 8. REVIEWS (surface) ================== */ ?>
<?php
$tests = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $tests->have_posts() ) : ?>
	<section class="border-y-2 border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">Reviews</span>
				<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">What neighbors say</h2>
			</div>
			<div class="mt-12 grid gap-6 md:grid-cols-3">
				<?php while ( $tests->have_posts() ) : $tests->the_post();
					$author = get_field( 'author_name' ); $role = get_field( 'author_role' );
					$quote = get_field( 'quote' ); $stars = (int) get_field( 'rating' ); ?>
					<figure class="card flex flex-col p-6" data-reveal>
						<?php if ( $stars ) : ?><span class="flex gap-0.5 text-cta"><?php for ( $s = 0; $s < $stars; $s++ ) { echo sdp_icon( 'star', 'h-4 w-4 fill-current' ); } ?></span><?php endif; ?>
						<blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink">&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</blockquote>
						<figcaption class="mt-5 text-sm"><span class="font-semibold"><?php echo esc_html( $author ); ?></span><?php if ( $role ) : ?><span class="text-muted"> · <?php echo esc_html( $role ); ?></span><?php endif; ?></figcaption>
					</figure>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php /* ================== 9. SERVICE AREA (paper) ================== */ ?>
<section class="px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto max-w-6xl text-center">
		<span class="eyebrow" data-reveal>Where we work</span>
		<h2 class="marker mt-4 inline-block text-3xl font-black uppercase tracking-tight sm:text-4xl" data-reveal>Serving Marianna &amp; Jackson County</h2>
		<div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
			<?php foreach ( $area as $town ) : ?>
				<span class="border-2 border-line bg-bg px-4 py-2 text-sm font-semibold"><?php echo esc_html( $town ); ?></span>
			<?php endforeach; ?>
		</div>
		<p class="mt-8 text-sm text-muted" data-reveal>Not sure if we reach you? <a href="<?php echo esc_url( home_url( '/service-area/' ) ); ?>" class="font-semibold text-accent underline underline-offset-2">Check the full area</a><?php if ( $phone ) : ?> or call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent underline underline-offset-2"><?php echo esc_html( $phone ); ?></a><?php endif; ?>.</p>
	</div>
</section>

<?php /* ================== 10. FAQ (surface) ================== */ ?>
<section class="border-t-2 border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto max-w-3xl">
		<div data-reveal>
			<span class="eyebrow">FAQ</span>
			<h2 class="marker mt-4 text-3xl font-black uppercase tracking-tight sm:text-4xl">Questions homeowners actually ask</h2>
		</div>
		<div class="mt-10 divide-y-2 divide-line border-y-2 border-line" x-data="{ open: null }" data-reveal>
			<?php foreach ( sdp_home_faqs() as $idx => $faq ) : $n = (int) $idx; ?>
				<div>
					<h3>
						<button type="button" id="faq-q-<?php echo $n; ?>" class="flex min-h-[44px] w-full items-center justify-between gap-4 py-4 text-left font-display font-bold" aria-expanded="false" :aria-expanded="(open === <?php echo $n; ?>).toString()" aria-controls="faq-a-<?php echo $n; ?>" @click="open = (open === <?php echo $n; ?> ? null : <?php echo $n; ?>)">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<span class="stat text-2xl leading-none text-accent" aria-hidden="true" x-text="open === <?php echo $n; ?> ? '–' : '+'">+</span>
						</button>
					</h3>
					<div id="faq-a-<?php echo $n; ?>" role="region" aria-labelledby="faq-q-<?php echo $n; ?>" x-show="open === <?php echo $n; ?>" x-cloak class="pb-5">
						<p class="text-sm leading-relaxed text-muted"><?php echo esc_html( $faq['a'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
