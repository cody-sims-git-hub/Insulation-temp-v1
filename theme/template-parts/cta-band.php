<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$cta_url = sdp_setting( 'cta_url', home_url( '/contact/' ) );
$phone   = sdp_setting( 'phone' );
?>
<section class="bg-accent px-5 py-16 text-accent-ink lg:px-8 lg:py-20">
	<div class="mx-auto flex max-w-5xl flex-col items-center gap-6 text-center">
		<h2 class="max-w-2xl text-3xl sm:text-4xl">Ready for a warmer, cooler, more efficient home?</h2>
		<p class="max-w-xl text-accent-ink/80">Free estimates across Marianna and Jackson County. No job too big or too small.</p>
		<div class="flex flex-col gap-3 sm:flex-row">
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-onaccent">Request a Free Estimate</a>
			<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="btn border border-accent-ink/40 text-accent-ink"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?> <?php echo esc_html( $phone ); ?></a><?php endif; ?>
		</div>
	</div>
</section>
