<?php
/**
 * Front page. Every section reads from the CMS (Site Settings + the Team /
 * Services / Testimonials post types). The client edits data, never this layout.
 * Delete or reorder sections per client; each hides itself when it has no content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$tagline   = sdp_setting( 'tagline', get_bloginfo( 'name' ) );
$intro     = sdp_setting( 'intro', get_bloginfo( 'description' ) );
$cta_url   = sdp_setting( 'cta_url', home_url( '/#contact' ) );
$cta_label = sdp_setting( 'cta_label', 'Get in touch' );
?>

<?php /* ============================ HERO ============================ */ ?>
<section class="relative overflow-hidden px-5 pb-20 pt-36 lg:px-8 lg:pb-28 lg:pt-44">
	<div class="mx-auto max-w-4xl text-center">
		<span class="eyebrow" data-reveal>Welcome</span>
		<h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl" data-reveal><?php echo esc_html( $tagline ); ?></h1>
		<?php if ( $intro ) : ?><p class="mx-auto mt-6 max-w-2xl text-lg text-muted" data-reveal><?php echo esc_html( $intro ); ?></p><?php endif; ?>
		<div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row" data-reveal>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?> <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
			<a href="#services" class="btn btn-ghost">Our services</a>
		</div>
	</div>
</section>

<?php /* ========================= SERVICES ========================= */ ?>
<?php
$services = new WP_Query( array( 'post_type' => 'service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $services->have_posts() ) :
	?>
	<section id="services" class="scroll-mt-20 border-t border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">What we do</span>
				<h2 class="mt-4 text-3xl sm:text-4xl">Services</h2>
			</div>
			<div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
				<?php
				while ( $services->have_posts() ) :
					$services->the_post();
					$summary  = get_field( 'summary' );
					$price    = get_field( 'price' );
					$featured = get_field( 'featured' );
					?>
					<article class="card flex flex-col p-6" data-reveal>
						<?php if ( $featured ) : ?><span class="mb-3 inline-flex w-fit rounded-full bg-accent/10 px-2.5 py-1 text-xs font-semibold text-accent">Popular</span><?php endif; ?>
						<h3 class="text-xl font-bold"><?php the_title(); ?></h3>
						<?php if ( $summary ) : ?><p class="mt-2 flex-1 text-sm leading-relaxed text-muted"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
						<?php if ( $price ) : ?><p class="mt-4 text-sm font-semibold text-accent"><?php echo esc_html( $price ); ?></p><?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php /* =========================== TEAM =========================== */ ?>
<?php
$team = new WP_Query( array( 'post_type' => 'team', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $team->have_posts() ) :
	?>
	<section id="team" class="scroll-mt-20 px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">Our team</span>
				<h2 class="mt-4 text-3xl sm:text-4xl">The people behind the work</h2>
			</div>
			<div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
				<?php
				while ( $team->have_posts() ) :
					$team->the_post();
					$role = get_field( 'role' );
					$bio  = get_field( 'bio' );
					$link = get_field( 'link' );
					?>
					<article data-reveal>
						<div class="flex aspect-square items-center justify-center overflow-hidden rounded-xl bg-surface-2 text-3xl font-bold text-muted/50">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span aria-hidden="true"><?php echo esc_html( sdp_initials( get_the_title() ) ); ?></span>
							<?php endif; ?>
						</div>
						<h3 class="mt-4 text-lg font-bold"><?php the_title(); ?></h3>
						<?php if ( $role ) : ?><p class="text-sm font-medium text-accent"><?php echo esc_html( $role ); ?></p><?php endif; ?>
						<?php if ( $bio ) : ?><p class="mt-2 text-sm leading-relaxed text-muted"><?php echo esc_html( $bio ); ?></p><?php endif; ?>
						<?php if ( $link ) : ?><a href="<?php echo esc_url( $link ); ?>" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-accent hover:underline">Profile <?php echo sdp_icon( 'arrow-up-right', 'h-3.5 w-3.5' ); ?></a><?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php /* ======================= TESTIMONIALS ======================= */ ?>
<?php
$tests = new WP_Query( array( 'post_type' => 'testimonial', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
if ( $tests->have_posts() ) :
	?>
	<section class="border-t border-line bg-surface px-5 py-20 lg:px-8 lg:py-28">
		<div class="mx-auto max-w-6xl">
			<div class="max-w-2xl" data-reveal>
				<span class="eyebrow">Testimonials</span>
				<h2 class="mt-4 text-3xl sm:text-4xl">What clients say</h2>
			</div>
			<div class="mt-12 grid gap-6 md:grid-cols-3">
				<?php
				while ( $tests->have_posts() ) :
					$tests->the_post();
					$author = get_field( 'author_name' );
					$role   = get_field( 'author_role' );
					$quote  = get_field( 'quote' );
					$stars  = (int) get_field( 'rating' );
					?>
					<figure class="card flex flex-col p-6" data-reveal>
						<?php if ( $stars ) : ?><span class="flex gap-0.5 text-accent"><?php for ( $i = 0; $i < $stars; $i++ ) { echo sdp_icon( 'star', 'h-4 w-4 fill-current' ); } ?></span><?php endif; ?>
						<blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink">“<?php echo esc_html( $quote ); ?>”</blockquote>
						<figcaption class="mt-5 text-sm"><span class="font-semibold"><?php echo esc_html( $author ); ?></span><?php if ( $role ) : ?><span class="text-muted"> · <?php echo esc_html( $role ); ?></span><?php endif; ?></figcaption>
					</figure>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php /* ========================= CONTACT ========================= */ ?>
<section id="contact" class="scroll-mt-20 px-5 py-20 lg:px-8 lg:py-28">
	<div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:gap-20">
		<div data-reveal>
			<span class="eyebrow">Get in touch</span>
			<h2 class="mt-4 text-3xl sm:text-4xl">Let's talk</h2>
			<p class="mt-4 max-w-md text-muted"><?php echo esc_html( sdp_setting( 'intro', 'Reach out and we\'ll get back to you shortly.' ) ); ?></p>
			<div class="mt-8 flex flex-col gap-3 sm:flex-row">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?></a>
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn btn-ghost"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $ph ); ?></a><?php endif; ?>
			</div>
		</div>
		<dl class="grid grid-cols-2 gap-6 self-start" data-reveal>
			<?php if ( $e = sdp_setting( 'email' ) ) : ?><div class="card p-5"><dt class="eyebrow">Email</dt><dd class="mt-2 text-sm"><a href="mailto:<?php echo esc_attr( $e ); ?>" class="hover:text-accent"><?php echo esc_html( $e ); ?></a></dd></div><?php endif; ?>
			<?php if ( $ph = sdp_setting( 'phone' ) ) : ?><div class="card p-5"><dt class="eyebrow">Phone</dt><dd class="mt-2 text-sm"><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="hover:text-accent"><?php echo esc_html( $ph ); ?></a></dd></div><?php endif; ?>
			<?php if ( $a = sdp_setting( 'address' ) ) : ?><div class="card p-5"><dt class="eyebrow">Visit</dt><dd class="mt-2 text-sm not-italic text-muted"><?php echo wp_kses( $a, array( 'br' => array() ) ); ?></dd></div><?php endif; ?>
			<?php if ( sdp_has_hours() ) : $today = sdp_hours(); ?><div class="card p-5"><dt class="eyebrow">Hours</dt><dd class="mt-2 space-y-1 text-xs text-muted"><?php foreach ( array_slice( $today, 0, 3 ) as $r ) : ?><div class="flex justify-between gap-3"><span><?php echo esc_html( substr( $r['day'], 0, 3 ) ); ?></span><span class="tabular-nums"><?php echo esc_html( $r['time'] ); ?></span></div><?php endforeach; ?></dd></div><?php endif; ?>
		</dl>
	</div>
</section>

<?php get_footer();
