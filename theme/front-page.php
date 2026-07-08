<?php
/**
 * A Plus Insulation — front page. Swiss/eco long-scroll. Data comes from the
 * CMS (Site Settings + Service / Testimonial CPTs); this file owns layout only.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$tagline   = sdp_setting( 'tagline', get_bloginfo( 'name' ) );
$intro     = sdp_setting( 'intro', get_bloginfo( 'description' ) );
$cta_url   = sdp_setting( 'cta_url', home_url( '/contact/' ) );
$cta_label = sdp_setting( 'cta_label', 'Free Estimate' );
$phone     = sdp_setting( 'phone' );
$area = array( 'Marianna', 'Sneads', 'Graceville', 'Chipley', 'Alford', 'Bonifay', 'Cottondale', 'Grand Ridge', 'Malone', 'Cypress' );
?>

<?php /* ============================ HERO ============================ */ ?>
<section class="relative overflow-hidden border-b border-line px-5 pb-20 pt-36 lg:px-8 lg:pb-28 lg:pt-44">
	<div class="mx-auto max-w-4xl text-center">
		<span class="eyebrow" data-reveal>Insulation Contractor · Marianna, FL</span>
		<h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl" data-reveal><?php echo esc_html( $tagline ); ?></h1>
		<?php if ( $intro ) : ?><p class="mx-auto mt-6 max-w-2xl text-lg text-muted" data-reveal><?php echo esc_html( $intro ); ?></p><?php endif; ?>
		<div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row" data-reveal>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?> <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
			<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn btn-ghost"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $phone ); ?></a><?php endif; ?>
		</div>
	</div>
</section>

<?php /* ========================= TRUST BAR ========================= */ ?>
<section class="border-b border-line bg-surface px-5 py-10 lg:px-8">
	<div class="mx-auto grid max-w-6xl grid-cols-2 gap-6 text-center md:grid-cols-4">
		<?php
		$stats = array(
			array( 'n' => 'Est. 2006', 'l' => 'Locally owned' ),
			array( 'n' => '18+ yrs',   'l' => 'In business' ),
			array( 'n' => 'Licensed',  'l' => '& insured' ),
			array( 'n' => 'Free',      'l' => 'Estimates' ),
		);
		foreach ( $stats as $s ) : ?>
			<div data-reveal>
				<p class="stat text-2xl font-bold text-accent sm:text-3xl"><?php echo esc_html( $s['n'] ); ?></p>
				<p class="mt-1 text-sm text-muted"><?php echo esc_html( $s['l'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php /* =================== SERVICES (BENTO) ==================== */ ?>
<?php
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $services->have_posts() ) :
	$svc_icons = array( 'shield', 'wind', 'layers', 'sun', 'recycle', 'home' );
	$i = 0; ?>
	<section id="services" class="scroll-mt-20 px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">What we do</span>
				<h2 class="mt-4 text-3xl sm:text-4xl">Whole-home insulation, done right</h2>
			</div>
			<div class="mt-12 grid auto-rows-fr gap-4 sm:grid-cols-2 lg:grid-cols-3">
				<?php while ( $services->have_posts() ) : $services->the_post();
					$summary = get_field( 'summary' );
					$icon = $svc_icons[ $i % count( $svc_icons ) ]; $i++;
					$span = ( 1 === $i ) ? 'sm:col-span-2' : ''; ?>
					<article class="card flex flex-col p-6 <?php echo esc_attr( $span ); ?>" data-reveal>
						<span class="flex h-11 w-11 items-center justify-center rounded bg-accent/10 text-accent"><?php echo sdp_icon( $icon, 'h-5 w-5' ); ?></span>
						<h3 class="mt-4 text-xl font-bold"><?php the_title(); ?></h3>
						<?php if ( $summary ) : ?><p class="mt-2 flex-1 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<div class="mt-10" data-reveal><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="inline-flex items-center gap-1 font-semibold text-accent hover:underline">All services <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a></div>
		</div>
	</section>
<?php endif; ?>

<?php /* =================== WHY INSULATION ==================== */ ?>
<section class="border-y border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:items-center lg:gap-20">
		<div data-reveal>
			<span class="eyebrow">Why it matters</span>
			<h2 class="mt-4 text-3xl sm:text-4xl">Comfort you feel, savings you keep</h2>
			<p class="mt-5 text-muted">In the Florida Panhandle, your AC works hardest against the heat that pours through an under-insulated attic and walls. Sealing and insulating properly means a home that stays comfortable and a power bill that stops climbing.</p>
			<ul class="mt-6 space-y-3">
				<?php foreach ( array( 'Lower cooling bills all summer', 'Even, comfortable temperatures room to room', 'Less strain — and longer life — for your AC', 'A quieter, less humid, healthier home' ) as $point ) : ?>
					<li class="flex items-start gap-3 text-sm"><span class="mt-0.5 text-accent"><?php echo sdp_icon( 'check', 'h-5 w-5' ); ?></span><span><?php echo esc_html( $point ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="grid grid-cols-2 gap-4" data-reveal>
			<?php
			$facts = array(
				array( 'i' => 'bolt',  'n' => 'Up to 15%', 'l' => 'potential energy savings from air-sealing & insulation*' ),
				array( 'i' => 'sun',   'n' => 'R-49',      'l' => 'DOE-recommended attic R-value for our zone' ),
				array( 'i' => 'leaf',  'n' => 'Year-round', 'l' => 'cooler summers, warmer winters' ),
				array( 'i' => 'shield','n' => 'Sealed',    'l' => 'against heat, moisture & pests' ),
			);
			foreach ( $facts as $f ) : ?>
				<div class="card p-5">
					<span class="text-accent"><?php echo sdp_icon( $f['i'], 'h-6 w-6' ); ?></span>
					<p class="stat mt-3 text-2xl font-bold"><?php echo esc_html( $f['n'] ); ?></p>
					<p class="mt-1 text-xs leading-relaxed text-muted"><?php echo esc_html( $f['l'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php /* =================== SERVICE AREA ==================== */ ?>
<section class="px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto max-w-6xl text-center">
		<span class="eyebrow" data-reveal>Where we work</span>
		<h2 class="mt-4 text-3xl sm:text-4xl" data-reveal>Serving Marianna &amp; Jackson County</h2>
		<div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
			<?php foreach ( $area as $town ) : ?>
				<span class="rounded border border-line bg-surface px-4 py-2 text-sm font-medium"><?php echo esc_html( $town ); ?></span>
			<?php endforeach; ?>
		</div>
		<p class="mt-8 text-sm text-muted" data-reveal>Not sure if we reach you? <a href="<?php echo esc_url( home_url( '/service-area/' ) ); ?>" class="font-semibold text-accent hover:underline">Check the full area</a> or call <a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="font-semibold text-accent hover:underline"><?php echo esc_html( $phone ); ?></a>.</p>
	</div>
</section>

<?php /* =================== TESTIMONIALS ==================== */ ?>
<?php
$tests = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $tests->have_posts() ) : ?>
	<section class="border-t border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal><span class="eyebrow">Reviews</span><h2 class="mt-4 text-3xl sm:text-4xl">What neighbors say</h2></div>
			<div class="mt-12 grid gap-6 md:grid-cols-3">
				<?php while ( $tests->have_posts() ) : $tests->the_post();
					$author = get_field( 'author_name' ); $role = get_field( 'author_role' );
					$quote = get_field( 'quote' ); $stars = (int) get_field( 'rating' ); ?>
					<figure class="card flex flex-col p-6" data-reveal>
						<?php if ( $stars ) : ?><span class="flex gap-0.5 text-accent"><?php for ( $s = 0; $s < $stars; $s++ ) { echo sdp_icon( 'star', 'h-4 w-4 fill-current' ); } ?></span><?php endif; ?>
						<blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink">“<?php echo esc_html( $quote ); ?>”</blockquote>
						<figcaption class="mt-5 text-sm"><span class="font-semibold"><?php echo esc_html( $author ); ?></span><?php if ( $role ) : ?><span class="text-muted"> · <?php echo esc_html( $role ); ?></span><?php endif; ?></figcaption>
					</figure>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
