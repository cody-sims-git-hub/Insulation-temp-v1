<?php
/**
 * Shared post-listing body used by home.php (blog index), archive.php and index.php.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="px-5 pb-20 pt-36 lg:px-8 lg:pb-28 lg:pt-44">
	<div class="mx-auto max-w-6xl">
		<div class="max-w-2xl">
			<span class="eyebrow">Blog</span>
			<h1 class="mt-4 text-4xl sm:text-5xl"><?php echo esc_html( ( is_home() || is_front_page() ) ? 'Latest writing' : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="mt-14 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="group flex flex-col">
						<a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden rounded-xl bg-surface-2">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
							<?php endif; ?>
						</a>
						<div class="mt-4 flex items-center gap-2 text-xs text-muted">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php $cats = get_the_category(); if ( $cats ) : ?><span>·</span><span class="font-medium text-accent"><?php echo esc_html( $cats[0]->name ); ?></span><?php endif; ?>
						</div>
						<h2 class="mt-2 text-xl font-bold leading-snug transition-colors group-hover:text-accent"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="mt-2 flex-1 text-sm leading-relaxed text-muted"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="mt-14 text-sm text-muted [&_a]:mx-1 [&_a:hover]:text-accent [&_.current]:font-bold [&_.current]:text-ink">
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Prev', 'next_text' => 'Next →' ) ); ?>
			</div>
		<?php else : ?>
			<p class="mt-14 text-muted">No posts yet.</p>
		<?php endif; ?>
	</div>
</section>
