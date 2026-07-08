<?php
/**
 * Generic page (About, Privacy, Terms, etc.). The home page uses front-page.php.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) : the_post();
	?>
	<article class="px-5 pb-20 pt-36 lg:pt-44">
		<div class="mx-auto max-w-3xl">
			<h1 class="text-4xl leading-tight sm:text-5xl"><?php the_title(); ?></h1>
			<div class="prose-sdp mt-8"><?php the_content(); ?></div>
		</div>
	</article>
<?php
endwhile;
get_footer();
