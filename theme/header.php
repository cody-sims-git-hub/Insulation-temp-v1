<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$blog_url  = ( $bp = get_option( 'page_for_posts' ) ) ? get_permalink( $bp ) : home_url( '/blog/' );
$nav       = array(
	array( 'label' => 'Services',     'url' => home_url( '/services/' ) ),
	array( 'label' => 'About',        'url' => home_url( '/about/' ) ),
	array( 'label' => 'Service Area', 'url' => home_url( '/service-area/' ) ),
	array( 'label' => 'Contact',      'url' => home_url( '/contact/' ) ),
);
$cta_url   = sdp_setting( 'cta_url', home_url( '/#contact' ) );
$cta_label = sdp_setting( 'cta_label', 'Get in touch' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.className += ' has-js';</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen bg-bg text-ink antialiased' ); ?>>
<?php wp_body_open(); ?>
<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-accent focus:px-4 focus:py-2 focus:text-accent-ink">
	<?php esc_html_e( 'Skip to content', 'sdp-starter' ); ?>
</a>

<div x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20">
	<header :class="scrolled ? 'border-line bg-bg/90 backdrop-blur' : 'border-transparent'" class="fixed inset-x-0 top-0 z-40 border-b transition-colors duration-300">
		<div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-4 lg:px-8">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-lg font-bold tracking-tight" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</a>

			<nav class="hidden items-center gap-8 lg:flex" aria-label="Primary">
				<?php foreach ( $nav as $item ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="text-sm font-medium text-muted transition-colors hover:text-ink"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>

			<div class="hidden items-center gap-4 lg:flex">
				<?php if ( $ph = sdp_setting( 'phone' ) ) : ?>
					<a href="tel:<?php echo esc_attr( sdp_setting( 'phone_href' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-ink hover:text-accent"><?php echo sdp_icon( 'phone', 'h-4 w-4' ); ?><?php echo esc_html( $ph ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_label ); ?></a>
			</div>

			<button @click="open = true" class="text-ink lg:hidden" aria-label="Open menu"><?php echo sdp_icon( 'menu', 'h-6 w-6' ); ?></button>
		</div>
	</header>

	<div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto bg-bg lg:hidden">
		<div class="flex items-center justify-between px-5 py-4">
			<span class="text-lg font-bold"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			<button @click="open = false" class="text-ink" aria-label="Close menu"><?php echo sdp_icon( 'close', 'h-6 w-6' ); ?></button>
		</div>
		<nav class="flex flex-col px-5 pt-6" aria-label="Mobile">
			<?php foreach ( $nav as $item ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>" @click="open = false" class="border-b border-line py-4 text-2xl font-semibold"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
			<a href="<?php echo esc_url( $cta_url ); ?>" @click="open = false" class="btn btn-primary mt-8 w-full"><?php echo esc_html( $cta_label ); ?></a>
		</nav>
	</div>
</div>

<main id="main">
