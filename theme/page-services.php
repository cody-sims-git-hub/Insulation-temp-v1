<?php
/**
 * Services page — six deep service sections with costs, tradeoffs, and mini-FAQs.
 * Static content lives here by design (CPT cards remain the Home teaser).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
set_query_var( 'hero', array(
	'eyebrow' => 'Services',
	'title'   => 'Home Insulation Services in Marianna & the Florida Panhandle',
	'lead'    => 'Spray foam, blown-in, batt & roll, radiant barrier, removal and replacement — with straight answers on the best insulation for Florida homes, what it really costs, and what we would put in our own attic.',
) );
get_template_part( 'template-parts/page-hero' );

$contact_url = home_url( '/contact/' );

$jump_nav = array(
	'spray-foam'      => 'Spray Foam',
	'blown-in'        => 'Blown-In',
	'batt-roll'       => 'Batt & Roll',
	'radiant-barrier' => 'Radiant Barrier',
	'removal'         => 'Removal',
	'replacement'     => 'Replacement',
);

$sections = array(
	array(
		'id'        => 'spray-foam',
		'icon'      => 'shield',
		'title'     => 'Spray Foam Insulation',
		'what'      => 'Spray polyurethane foam comes in two types — open cell and closed cell — and both do something no other insulation can: they seal air leaks and insulate in one step. The foam expands into cracks and gaps as it goes on, so conditioned air stays in and muggy Panhandle air stays out. It is the highest R-value per inch of any insulation we install.',
		'best'      => array( 'Attic roof decks', 'New-construction walls', 'Rim joists', 'Metal buildings' ),
		'r_stat'    => '~R-6.5',
		'r_note'    => 'per inch for closed cell; open cell runs ~R-3.7 per inch — the highest R-value per inch available. Florida attic code calls for R-30–R-38.',
		'tradeoffs' => 'It\'s the premium option — $3.00–$7.00 per square foot installed. And one thing most contractors won\'t mention: when foam covers a roof deck, some lenders and home inspectors ask questions at sale or re-roof time. We walk you through venting and inspection-access choices up front so there are no surprises.',
		'cost_stat' => '$3.00–$7.00',
		'cost_note' => 'per square foot installed',
		'faqs'      => array(
			array(
				'q' => 'Is spray foam worth it?',
				'a' => 'For attic roof decks and new construction, usually yes — it air-seals and insulates in one step, and the comfort difference is immediate. It costs more up front than any other option. We\'ll tell you honestly when blown-in gets you most of the benefit for less.',
			),
			array(
				'q' => 'Is spray foam better than fiberglass?',
				'a' => 'It seals air leaks, which fiberglass can\'t do, and it packs more R-value into every inch. Fiberglass wins on budget — it insulates well for a fraction of the cost when it\'s installed right. Which is better depends on your house and your budget, and we\'ll tell you which one we\'d pick for yours.',
			),
		),
	),
	array(
		'id'        => 'blown-in',
		'icon'      => 'wind',
		'title'     => 'Blown-In Insulation',
		'what'      => 'Loose-fill fiberglass or cellulose blown into the attic through a hose — fast, even, and gap-free. It flows around joists, wires, and odd framing where batts leave voids, and it can be installed right over your existing insulation. For most Panhandle attics, it\'s the most cost-effective top-up there is.',
		'best'      => array( 'Attic floors', 'Top-ups over existing insulation', 'Older homes', 'Budget retrofits' ),
		'r_stat'    => 'R-38',
		'r_note'    => 'the attic target we blow to for most NW Florida homes — code calls for R-30–R-38, and we set the installed depth to get you there.',
		'tradeoffs' => 'Blown-in doesn\'t air-seal by itself — that\'s why we seal penetrations around pipes, wires, and fixtures before the hose comes out. And loose fill settles slightly over time, so we account for that in the installed depth instead of blowing to the bare minimum.',
		'cost_stat' => '$1.00–$2.50',
		'cost_note' => 'per square foot installed',
		'faqs'      => array(
			array(
				'q' => 'Is blown-in better than batts?',
				'a' => 'In attics, usually — loose fill flows around joists, wires, and odd framing, so there are no gaps. Batts shine in open walls during construction or a remodel. We\'ll recommend whichever fits your house, not whichever we feel like selling.',
			),
			array(
				'q' => 'Fiberglass or cellulose?',
				'a' => 'Both work well when they\'re installed to the right depth. Fiberglass resists moisture better — worth a lot in our humidity — while cellulose is denser. We recommend per house, not per preference.',
			),
		),
	),
	array(
		'id'        => 'batt-roll',
		'icon'      => 'layers',
		'title'     => 'Batt & Roll Insulation',
		'what'      => 'Fiberglass batts and rolls are the classic — pre-cut blankets of insulation fitted between studs and joists. In open walls, floors, garages, and new construction, they\'re dependable, predictable, and the most budget-friendly way to hit a target R-value.',
		'best'      => array( 'Open walls', 'Floors', 'Garages', 'New construction' ),
		'r_stat'    => 'R-30–R-38',
		'r_note'    => 'Florida\'s attic code range. Batts carry a fixed, labeled R-value — but the number on the package only holds if the fit is right.',
		'tradeoffs' => 'Batt performance depends entirely on fit. A batt that\'s compressed, gapped, or stuffed around wiring underperforms its labeled rating — sometimes badly. That\'s why installation quality is the whole game, and why we cut around obstructions instead of cramming past them.',
		'cost_stat' => '$1.00–$3.00',
		'cost_note' => 'per square foot installed',
		'faqs'      => array(
			array(
				'q' => 'What\'s the difference between batts and rolls?',
				'a' => 'Same material, different packaging. Batts come pre-cut to standard stud and joist lengths; rolls are continuous and get cut on site, which suits long open runs. We use whichever produces the fewest seams and gaps in your framing.',
			),
			array(
				'q' => 'Batt or spray foam?',
				'a' => 'Batts cost less — $1.00–$3.00 per square foot against $3.00–$7.00 for foam — and in an open wall they do the job well. Foam adds air sealing and a higher R-value per inch, which matters most at roof decks and rim joists. For many projects the honest answer is batts in the walls and foam where sealing counts.',
			),
		),
	),
	array(
		'id'        => 'radiant-barrier',
		'icon'      => 'sun',
		'title'     => 'Radiant Barrier',
		'what'      => 'A radiant barrier is reflective foil installed under the roof deck that turns back radiant heat before it cooks your attic. In a Florida summer that means a meaningful drop in attic temperature — and less heat soaking into your ductwork and ceilings. It complements insulation; it never replaces it.',
		'best'      => array( 'Under the roof deck', 'Attics with AC ductwork', 'Florida summer heat', 'Pairing with blown-in' ),
		'r_stat'    => 'R-0',
		'r_note'    => 'a radiant barrier adds no R-value of its own. It blocks radiant heat instead — which is exactly why it works alongside insulation, never instead of it.',
		'tradeoffs' => 'It\'s a summer specialist. A radiant barrier does its best work when the sun is beating on the roof; in winter the effect is modest. And it only pays off if your insulation is up to par first — foil over a thin attic is polish on a problem.',
		'cost_stat' => '$1.00–$2.00',
		'cost_note' => 'per square foot installed',
		'faqs'      => array(
			array(
				'q' => 'Is a radiant barrier worth it?',
				'a' => 'In a cooling climate like ours, yes — especially when your AC ductwork runs through the attic, where every degree of attic temperature matters. It\'s one of the more affordable upgrades we install. We\'ll tell you if your money is better spent on insulation depth first.',
			),
			array(
				'q' => 'Does a radiant barrier help in winter?',
				'a' => 'Its job is summer heat, and that\'s where it earns its keep. The winter effect is modest — nothing like the summer gain. If winter comfort is the problem, insulation depth and air sealing come first.',
			),
		),
	),
	array(
		'id'        => 'removal',
		'icon'      => 'recycle',
		'title'     => 'Insulation Removal',
		'what'      => 'When insulation gets wet, moldy, or visited by pests, it stops working and starts causing problems. We remove it safely — vacuum-and-bag, sealed on the way out — and haul it off. Removal is the right call after water damage, rodent infestation, fire or smoke damage, during a renovation, or when prepping an attic for spray foam.',
		'best'      => array( 'Water-damaged insulation', 'Pest & rodent damage', 'Fire or smoke damage', 'Renovation prep', 'Before spray foam' ),
		'r_stat'    => 'R-11',
		'r_note'    => 'or less is what many older Jackson County attics measure. Removal clears the deck to rebuild toward the R-30–R-38 Florida code calls for.',
		'tradeoffs' => 'Removal by itself doesn\'t save you a dime — it\'s step one, not the fix. And if your existing insulation is dry, clean, and pest-free, you may not need it at all: blowing new insulation over the old is cheaper and works fine. We\'ll tell you which situation you\'re in.',
		'cost_stat' => '$1.00–$2.00',
		'cost_note' => 'per square foot',
		'faqs'      => array(
			array(
				'q' => 'Do I have to remove old insulation before adding new?',
				'a' => 'Usually not. If it\'s dry, clean, and pest-free, we blow new insulation right over it. Removal earns its cost when the old material is wet, moldy, or contaminated — or when a roof deck is being prepped for spray foam.',
			),
			array(
				'q' => 'What happens to the old insulation?',
				'a' => 'We vacuum it into sealed bags rather than dragging loose material through your house, then haul everything off the property. You\'re left with a clean attic, ready for whatever comes next.',
			),
		),
	),
	array(
		'id'        => 'replacement',
		'icon'      => 'home',
		'title'     => 'Insulation Replacement',
		'what'      => 'Replacement is the full job: tear out what\'s up there, fix what caused the damage, and re-insulate to today\'s standard. For many pre-1990 homes in Jackson County it\'s the biggest single efficiency upgrade available. The signs it\'s time: insulation 20+ years old, bills climbing year over year, uneven room temperatures, or past roof and plumbing leaks.',
		'best'      => array( 'Pre-1990 homes', '20+ year-old insulation', 'Homes with past leaks', 'Uneven rooms & climbing bills' ),
		'r_stat'    => 'R-38',
		'r_note'    => 'the sweet spot for our climate zone — Florida code calls for R-30–R-38 in attics, and replacement is the chance to hit it properly.',
		'tradeoffs' => 'Replacement costs more than topping up, because you\'re paying for removal plus new material. If your existing insulation is healthy, a blown-in top-up gets you most of the benefit for less — we\'ll measure what\'s up there and tell you straight which job your attic actually needs.',
		'cost_stat' => '$2.00–$4.50',
		'cost_note' => 'per square foot for the most common combination — removal plus blown-in. Spray foam replacement runs more.',
		'faqs'      => array(
			array(
				'q' => 'How often should insulation be replaced?',
				'a' => 'Good insulation can last decades — but not if it\'s been wet, compressed, or visited by pests. If your home is 20+ years old and the bills keep climbing, it\'s worth having the attic measured. We check depth and condition for free.',
			),
			array(
				'q' => 'Does attic insulation go bad?',
				'a' => 'It doesn\'t expire, but it does degrade. Moisture flattens it, pests contaminate it, and settling thins it out — and every one of those cuts its real R-value below the label. A twenty-minute look in the attic tells us whether yours is still doing its job.',
			),
		),
	),
);

$applications = 'Attic · Ceilings · Interior & exterior walls · Floors · Crawlspace · Garage · Roof deck';

$process = array(
	array( 'Call or send the form', 'You reach us, not a call center — same or next business day, we set a time.' ),
	array( 'Free attic assessment', 'We measure what you have — depth, condition, air leaks — and show you photos of what we find.' ),
	array( 'A written, honest number', 'Flat pricing, material options explained, no pressure. The estimate is yours either way.' ),
	array( 'Install day', 'Most attics are done in a day. We clean up, haul off the mess, and you feel the difference the first hot afternoon.' ),
);
?>

<nav class="border-b border-line bg-surface px-5 py-5 lg:px-8" aria-label="Jump to a service">
	<div class="mx-auto flex max-w-5xl flex-wrap gap-3">
		<?php foreach ( $jump_nav as $anchor => $label ) : ?>
			<a href="#<?php echo esc_attr( $anchor ); ?>" class="inline-flex min-h-[44px] items-center rounded-full border-2 border-line bg-bg px-5 font-display text-sm font-bold text-ink transition-colors hover:border-ink"><?php echo esc_html( $label ); ?></a>
		<?php endforeach; ?>
	</div>
</nav>

<?php foreach ( $sections as $i => $s ) :
	$on_paper = ( 0 === $i % 2 );                       // alternate bg-bg / bg-surface bands
	$band     = $on_paper ? 'bg-bg' : 'bg-surface';
	$box_bg   = $on_paper ? 'bg-surface' : 'bg-bg';      // boxes/chips take the opposite fill
?>
<section id="<?php echo esc_attr( $s['id'] ); ?>" class="scroll-mt-24 border-b border-line <?php echo esc_attr( $band ); ?> px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto max-w-3xl">
		<div class="flex items-center gap-4" data-reveal>
			<span class="flex h-12 w-12 shrink-0 items-center justify-center border-2 border-line <?php echo esc_attr( $box_bg ); ?> text-accent"><?php echo sdp_icon( $s['icon'], 'h-6 w-6' ); ?></span>
			<h2 class="marker text-3xl font-black uppercase tracking-tight sm:text-4xl"><?php echo esc_html( $s['title'] ); ?></h2>
		</div>

		<p class="mt-7 text-base leading-relaxed text-ink sm:text-lg" data-reveal><?php echo esc_html( $s['what'] ); ?></p>

		<div class="mt-7" data-reveal>
			<p class="font-display text-xs font-bold uppercase tracking-[0.14em] text-muted">Best for</p>
			<ul class="mt-3 flex flex-wrap gap-2.5">
				<?php foreach ( $s['best'] as $chip ) : ?>
					<li class="inline-flex items-center rounded-full border-2 border-line <?php echo esc_attr( $box_bg ); ?> px-3.5 py-1.5 text-sm font-semibold text-ink"><?php echo esc_html( $chip ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="mt-7 border-2 border-line <?php echo esc_attr( $box_bg ); ?> p-5" data-reveal>
			<p class="font-display text-xs font-bold uppercase tracking-[0.14em] text-muted">R-value guidance</p>
			<p class="mt-2"><span class="stat text-3xl text-accent sm:text-4xl"><?php echo esc_html( $s['r_stat'] ); ?></span> <span class="text-sm leading-relaxed text-muted"><?php echo esc_html( $s['r_note'] ); ?></span></p>
		</div>

		<div class="mt-7 border-l-4 border-cta pl-5" data-reveal>
			<h3 class="text-lg font-bold">Honest tradeoffs</h3>
			<p class="mt-2 text-sm leading-relaxed text-muted sm:text-base"><?php echo esc_html( $s['tradeoffs'] ); ?></p>
		</div>

		<div class="mt-7 border-2 border-line <?php echo esc_attr( $box_bg ); ?> p-5" data-reveal>
			<p class="font-display text-xs font-bold uppercase tracking-[0.14em] text-muted">Typical cost</p>
			<p class="mt-2"><span class="stat text-3xl text-accent sm:text-4xl"><?php echo esc_html( $s['cost_stat'] ); ?></span> <span class="text-sm leading-relaxed text-muted"><?php echo esc_html( $s['cost_note'] ); ?></span></p>
		</div>

		<div class="mt-8 space-y-6" data-reveal>
			<?php foreach ( $s['faqs'] as $faq ) : ?>
				<div>
					<h3 class="text-base font-bold sm:text-lg"><?php echo esc_html( $faq['q'] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-muted"><?php echo esc_html( $faq['a'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<a href="<?php echo esc_url( $contact_url ); ?>" class="mt-9 inline-flex min-h-[44px] items-center gap-2 font-display font-bold text-accent underline-offset-4 hover:underline" data-reveal>Get a free estimate <?php echo sdp_icon( 'arrow', 'h-4 w-4' ); ?></a>
	</div>
</section>
<?php endforeach; ?>

<section class="border-b border-line bg-bg px-5 py-16 lg:px-8 lg:py-20">
	<div class="mx-auto max-w-5xl">
		<div class="grid overflow-hidden border-2 border-line md:grid-cols-2" data-reveal>
			<img src="<?php echo esc_url( SDP_URI . '/assets/photos/jobsite.jpg' ); ?>" alt="A Plus Insulation trucks at a Marianna, FL job site" class="h-full min-h-[260px] w-full object-cover" loading="lazy">
			<div class="bg-surface p-8">
				<h2 class="text-2xl font-bold uppercase tracking-tight">Where we insulate</h2>
				<p class="mt-3 text-sm leading-relaxed text-muted"><?php echo esc_html( $applications ); ?></p>
				<p class="mt-4 text-sm leading-relaxed text-muted">New construction or existing home — we assess your space and recommend the right material and R-value for the Panhandle climate.</p>
			</div>
		</div>
	</div>
</section>

<section class="bg-accent px-5 py-16 text-accent-ink lg:px-8 lg:py-20">
	<div class="mx-auto max-w-5xl">
		<p class="font-display text-xs font-bold uppercase tracking-[0.14em] text-accent-ink/70" data-reveal>How it works</p>
		<h2 class="marker mt-3 text-3xl font-black uppercase tracking-tight sm:text-4xl" data-reveal>From first call to install day</h2>
		<ol class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( $process as $n => $step ) : ?>
				<li data-reveal>
					<span class="stat text-4xl text-cta" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $n + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="mt-3 text-lg font-bold"><?php echo esc_html( $step[0] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-accent-ink/80"><?php echo esc_html( $step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer();
