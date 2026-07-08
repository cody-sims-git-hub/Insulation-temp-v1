<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$h = get_query_var( 'hero', array() );
$eyebrow = isset( $h['eyebrow'] ) ? $h['eyebrow'] : '';
$title   = isset( $h['title'] ) ? $h['title'] : get_the_title();
$lead    = isset( $h['lead'] ) ? $h['lead'] : '';
?>
<section class="border-b border-line px-5 pb-14 pt-36 lg:px-8 lg:pt-44">
	<div class="mx-auto max-w-4xl">
		<?php if ( $eyebrow ) : ?><span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
		<h1 class="mt-4 text-4xl leading-tight sm:text-5xl" data-reveal><?php echo esc_html( $title ); ?></h1>
		<?php if ( $lead ) : ?><p class="mt-5 max-w-2xl text-lg text-muted" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	</div>
</section>
