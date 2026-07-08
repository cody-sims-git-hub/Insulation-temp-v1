<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$blog_url = ( $bp = get_option( 'page_for_posts' ) ) ? get_permalink( $bp ) : home_url( '/blog/' );
$socials  = sdp_socials();
?>
</main>

<footer class="border-t border-line bg-surface">
	<div class="mx-auto max-w-6xl px-5 py-16 lg:px-8">
		<div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
			<div>
				<p class="text-lg font-bold"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
				<p class="mt-3 max-w-xs text-sm text-muted"><?php echo esc_html( sdp_setting( 'tagline', get_bloginfo( 'description' ) ) ); ?></p>
				<?php if ( $socials ) : ?>
					<div class="mt-5 flex gap-3">
						<?php foreach ( $socials as $net => $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-lg border border-line text-muted transition-colors hover:border-accent hover:text-accent" aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"><?php echo sdp_icon( $net ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div>
				<h3 class="eyebrow">Explore</h3>
				<ul class="mt-4 space-y-2.5 text-sm text-muted">
					<li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>" class="transition-colors hover:text-ink">Services</a></li>
					<li><a href="<?php echo esc_url( home_url( '/#team' ) ); ?>" class="transition-colors hover:text-ink">Team</a></li>
					<li><a href="<?php echo esc_url( $blog_url ); ?>" class="transition-colors hover:text-ink">Blog</a></li>
					<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="transition-colors hover:text-ink">Contact</a></li>
				</ul>
			</div>

			<div>
				<h3 class="eyebrow">Contact</h3>
				<ul class="mt-4 space-y-2.5 text-sm text-muted">
					<?php if ( $p = sdp_setting( 'phone' ) ) : ?><li><a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="transition-colors hover:text-ink"><?php echo esc_html( $p ); ?></a></li><?php endif; ?>
					<?php if ( $e = sdp_setting( 'email' ) ) : ?><li><a href="mailto:<?php echo esc_attr( $e ); ?>" class="transition-colors hover:text-ink"><?php echo esc_html( $e ); ?></a></li><?php endif; ?>
					<?php if ( $a = sdp_setting( 'address' ) ) : ?><li class="not-italic"><?php echo wp_kses( $a, array( 'br' => array() ) ); ?></li><?php endif; ?>
				</ul>
			</div>

			<?php if ( sdp_has_hours() ) : ?>
				<div>
					<h3 class="eyebrow">Hours</h3>
					<ul class="mt-4 space-y-1.5 text-sm">
						<?php foreach ( sdp_hours() as $row ) : ?>
							<li class="flex justify-between gap-4 text-muted">
								<span><?php echo esc_html( $row['day'] ); ?></span>
								<span class="tabular-nums"><?php echo esc_html( $row['time'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>

		<div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-line pt-6 text-center md:flex-row md:text-left">
			<p class="text-xs text-muted">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. All rights reserved.</p>
			<a href="https://www.simsdigitalpartners.com" target="_blank" rel="noopener" class="text-xs text-muted transition-colors hover:text-accent">Built by Sims Digital Partners</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
