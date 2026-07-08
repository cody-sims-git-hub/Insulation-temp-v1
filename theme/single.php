<?php
/**
 * Single blog post.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) : the_post();
	$cats = get_the_category();
	?>
	<article class="px-5 pb-20 pt-36 lg:pt-44">
		<div class="mx-auto max-w-3xl">
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="text-sm font-medium text-muted transition-colors hover:text-accent">← Blog</a>
			<div class="mt-6 flex items-center gap-2 text-sm text-muted">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<?php if ( $cats ) : ?><span>·</span><span class="font-medium text-accent"><?php echo esc_html( $cats[0]->name ); ?></span><?php endif; ?>
			</div>
			<h1 class="mt-3 text-4xl leading-tight sm:text-5xl"><?php the_title(); ?></h1>
		</div>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mx-auto mt-10 max-w-4xl">
				<div class="aspect-[16/9] overflow-hidden rounded-xl bg-surface-2"><?php the_post_thumbnail( 'large', array( 'class' => 'h-full w-full object-cover' ) ); ?></div>
			</div>
		<?php endif; ?>
		<div class="prose-sdp mx-auto mt-10 max-w-2xl"><?php the_content(); ?></div>
	</article>
<?php
endwhile;
get_footer();
