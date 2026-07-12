/**
 * A Plus Insulation — content source of truth.
 *
 * Copy, NAP, services, reviews, FAQ and SEO were harvested from the prior
 * WordPress build (2026-07-07 keyword plan) and preserved verbatim so the
 * rebuild keeps every ranking signal. In the headless setup this file is the
 * seam: swap these constants for WordPress REST/GraphQL reads at build time
 * and nothing downstream changes.
 */

export const business = {
  name: 'A Plus Insulation',
  tagline: 'A warmer, cooler, more efficient home',
  founded: 2006,
  phone: '(850) 555-0100',
  phoneHref: '+18505550100',
  email: 'info@example.com',
  address: { street: '1234 Main St', city: 'Your City', region: 'FL', postal: '32446' },
  mapsUrl: 'https://maps.google.com/?q=1234+Main+St+Your+City+FL+32446',
  mapsEmbed: 'https://www.google.com/maps?q=Your+City,+FL+32446&output=embed',
  facebook: 'https://www.facebook.com/example',
  hours: [
    { day: 'Monday', time: '8:00 AM – 5:00 PM', closed: false },
    { day: 'Tuesday', time: '8:00 AM – 5:00 PM', closed: false },
    { day: 'Wednesday', time: '8:00 AM – 5:00 PM', closed: false },
    { day: 'Thursday', time: '8:00 AM – 5:00 PM', closed: false },
    { day: 'Friday', time: '8:00 AM – 5:00 PM', closed: false },
    { day: 'Saturday', time: 'Closed', closed: true },
    { day: 'Sunday', time: 'Closed', closed: true },
  ],
} as const;

export const cta = {
  label: 'Get My Free Estimate',
  href: '/contact/',
} as const;

export const nav = [
  { label: 'Services', href: '/services/' },
  { label: 'About', href: '/about/' },
  { label: 'Service Area', href: '/service-area/' },
  { label: 'Contact', href: '/contact/' },
] as const;

/** Homepage hero + problem-section trust points. */
export const heroBadges = ['Est. 2006', 'Licensed & Insured', 'Free Estimates'] as const;

export const stats = [
  { n: '20', l: 'years insulating the Panhandle' },
  { n: '~15%', l: 'avg. heating & cooling savings from air sealing + insulation (ENERGY STAR)' },
  { n: 'R-38', l: 'recommended attic target for NW Florida' },
  { n: 'Free', l: 'written, itemized estimates — no obligation' },
] as const;

export const problemPoints = [
  'Lower cooling bills all summer',
  'Even, comfortable temperatures room to room',
  'Less strain — and longer life — for your AC',
  'A quieter, less humid, healthier home',
] as const;

export type Service = {
  id: string;
  icon: string;
  title: string;
  short: string;
  what: string;
  best: string[];
  tradeoffs: string;
  faqs: { q: string; a: string }[];
};

export const services: Service[] = [
  {
    id: 'spray-foam',
    icon: 'shield',
    title: 'Spray Foam Insulation',
    short:
      'Open- and closed-cell spray foam that seals air leaks and delivers the highest R-value per inch — ideal for Panhandle heat and humidity.',
    what:
      'Spray polyurethane foam comes in two types — open cell and closed cell — and both do something no other insulation can: they seal air leaks and insulate in one step. The foam expands into cracks and gaps as it goes on, so conditioned air stays in and muggy Panhandle air stays out. It packs the most insulating power into every inch of anything we install.',
    best: ['Attic roof decks', 'New-construction walls', 'Rim joists', 'Metal buildings'],
    tradeoffs:
      "It's the premium option. And one thing most contractors won't mention: when foam covers a roof deck, some lenders and home inspectors ask questions at sale or re-roof time. We walk you through venting and inspection-access choices up front so there are no surprises.",
    faqs: [
      {
        q: 'Is spray foam worth it?',
        a: "For attic roof decks and new construction, usually yes — it air-seals and insulates in one step, and the comfort difference is immediate. It costs more up front than any other option. We'll tell you honestly when blown-in gets you most of the benefit for less.",
      },
      {
        q: 'Is spray foam better than fiberglass?',
        a: "It seals air leaks, which fiberglass can't do, and it packs more insulating power into every inch. Fiberglass wins on budget — it insulates well for a fraction of the cost when it's installed right. Which is better depends on your house and your budget, and we'll tell you which one we'd pick for yours.",
      },
    ],
  },
  {
    id: 'blown-in',
    icon: 'wind',
    title: 'Blown-In Insulation',
    short:
      'Loose-fill cellulose or fiberglass blown into attics and walls for fast, even, gap-free coverage.',
    what:
      "Loose-fill fiberglass or cellulose blown into the attic through a hose — fast, even, and gap-free. It flows around joists, wires, and odd framing where batts leave voids, and it can be installed right over your existing insulation. For most Panhandle attics, it's the most cost-effective top-up there is.",
    best: ['Attic floors', 'Top-ups over existing insulation', 'Older homes', 'Budget retrofits'],
    tradeoffs:
      "Blown-in doesn't air-seal by itself — that's why we seal penetrations around pipes, wires, and fixtures before the hose comes out. And loose fill settles slightly over time, so we account for that in the installed depth instead of blowing to the bare minimum.",
    faqs: [
      {
        q: 'Is blown-in better than batts?',
        a: "In attics, usually — loose fill flows around joists, wires, and odd framing, so there are no gaps. Batts shine in open walls during construction or a remodel. We'll recommend whichever fits your house, not whichever we feel like selling.",
      },
      {
        q: 'Fiberglass or cellulose?',
        a: "Both work well when they're installed to the right depth. Fiberglass resists moisture better — worth a lot in our humidity — while cellulose is denser. We recommend per house, not per preference.",
      },
    ],
  },
  {
    id: 'batt-roll',
    icon: 'layers',
    title: 'Batt & Roll Insulation',
    short:
      'Fiberglass batts for walls, floors and new construction — a cost-effective, dependable standard.',
    what:
      "Fiberglass batts and rolls are the classic — pre-cut blankets of insulation fitted between studs and joists. In open walls, floors, garages, and new construction, they're dependable, predictable, and the most budget-friendly way to hit a target insulation level.",
    best: ['Open walls', 'Floors', 'Garages', 'New construction'],
    tradeoffs:
      "Batt performance depends entirely on fit. A batt that's compressed, gapped, or stuffed around wiring underperforms its labeled rating — sometimes badly. That's why installation quality is the whole game, and why we cut around obstructions instead of cramming past them.",
    faqs: [
      {
        q: "What's the difference between batts and rolls?",
        a: 'Same material, different packaging. Batts come pre-cut to standard stud and joist lengths; rolls are continuous and get cut on site, which suits long open runs. We use whichever produces the fewest seams and gaps in your framing.',
      },
      {
        q: 'Batt or spray foam?',
        a: 'Batts cost less than foam, and in an open wall they do the job well. Foam adds air sealing and more insulating power per inch, which matters most at roof decks and rim joists. For many projects the honest answer is batts in the walls and foam where sealing counts.',
      },
    ],
  },
  {
    id: 'radiant-barrier',
    icon: 'sun',
    title: 'Radiant Barrier',
    short:
      'Reflective foil that turns back radiant heat in the attic, easing the load on your AC all summer.',
    what:
      'A radiant barrier is reflective foil installed under the roof deck that turns back radiant heat before it cooks your attic. In a Florida summer that means a meaningful drop in attic temperature — and less heat soaking into your ductwork and ceilings. It complements insulation; it never replaces it.',
    best: ['Under the roof deck', 'Attics with AC ductwork', 'Florida summer heat', 'Pairing with blown-in'],
    tradeoffs:
      "It's a summer specialist. A radiant barrier does its best work when the sun is beating on the roof; in winter the effect is modest. And it only pays off if your insulation is up to par first — foil over a thin attic is polish on a problem.",
    faqs: [
      {
        q: 'Is a radiant barrier worth it?',
        a: "In a cooling climate like ours, yes — especially when your AC ductwork runs through the attic, where every degree of attic temperature matters. It's one of the more affordable upgrades we install. We'll tell you if your money is better spent on insulation depth first.",
      },
      {
        q: 'Does a radiant barrier help in winter?',
        a: "Its job is summer heat, and that's where it earns its keep. The winter effect is modest — nothing like the summer gain. If winter comfort is the problem, insulation depth and air sealing come first.",
      },
    ],
  },
  {
    id: 'removal',
    icon: 'recycle',
    title: 'Insulation Removal',
    short:
      'Safe removal of old, wet, moldy or pest-damaged insulation to prep for a clean replacement.',
    what:
      'When insulation gets wet, moldy, or visited by pests, it stops working and starts causing problems. We remove it safely — vacuum-and-bag, sealed on the way out — and haul it off. Removal is the right call after water damage, rodent infestation, fire or smoke damage, during a renovation, or when prepping an attic for spray foam.',
    best: ['Water-damaged insulation', 'Pest & rodent damage', 'Fire or smoke damage', 'Renovation prep', 'Before spray foam'],
    tradeoffs:
      "Removal by itself doesn't save you a dime — it's step one, not the fix. And if your existing insulation is dry, clean, and pest-free, you may not need it at all: blowing new insulation over the old is cheaper and works fine. We'll tell you which situation you're in.",
    faqs: [
      {
        q: 'Do I have to remove old insulation before adding new?',
        a: "Usually not. If it's dry, clean, and pest-free, we blow new insulation right over it. Removal earns its cost when the old material is wet, moldy, or contaminated — or when a roof deck is being prepped for spray foam.",
      },
      {
        q: 'What happens to the old insulation?',
        a: "We vacuum it into sealed bags rather than dragging loose material through your house, then haul everything off the property. You're left with a clean attic, ready for whatever comes next.",
      },
    ],
  },
  {
    id: 'replacement',
    icon: 'home',
    title: 'Insulation Replacement',
    short:
      'Full tear-out and re-insulation to restore comfort and lower energy bills in older homes.',
    what:
      "Replacement is the full job: tear out what's up there, fix what caused the damage, and re-insulate to today's standard. For many pre-1990 homes in Random County it's the biggest single efficiency upgrade available. The signs it's time: insulation 20+ years old, bills climbing year over year, uneven room temperatures, or past roof and plumbing leaks.",
    best: ['Pre-1990 homes', '20+ year-old insulation', 'Homes with past leaks', 'Uneven rooms & climbing bills'],
    tradeoffs:
      "Replacement costs more than topping up, because you're paying for removal plus new material. If your existing insulation is healthy, a blown-in top-up gets you most of the benefit for less — we'll measure what's up there and tell you straight which job your attic actually needs.",
    faqs: [
      {
        q: 'How often should insulation be replaced?',
        a: "Good insulation can last decades — but not if it's been wet, compressed, or visited by pests. If your home is 20+ years old and the bills keep climbing, it's worth having the attic measured. We check depth and condition for free.",
      },
      {
        q: 'Does attic insulation go bad?',
        a: "It doesn't expire, but it does degrade. Moisture flattens it, pests contaminate it, and settling thins it out — and every one of those cuts its real performance below the label. A twenty-minute look in the attic tells us whether yours is still doing its job.",
      },
    ],
  },
];

export const process = [
  { n: '01', t: 'Call or send the form', d: 'You reach us, not a call center. Same or next business day, we set a time.' },
  { n: '02', t: 'Free attic assessment', d: 'We measure what you have — depth, condition, air leaks — and show you photos of what we find.' },
  { n: '03', t: 'A written, honest number', d: 'One clear number, material options explained, no pressure. The estimate is yours either way.' },
  { n: '04', t: 'Install day', d: 'Most attics are done in a day. We clean up, haul off the mess, and you feel the difference the first hot afternoon.' },
] as const;

export const gallery = [
  { f: 'attic-foam.jpg', c: 'Spray foam attic — Random County', a: 'Spray foam and batt insulation on an attic roof deck and wall in a Random County home' },
  { f: 'foam-walls.jpg', c: 'Foamed walls & ceiling — Your City', a: 'Closed-cell spray foam insulation across the interior walls and ceiling of a Your City building' },
  { f: 'foam-ceiling.jpg', c: 'Ceiling spray foam — Panhandle', a: 'Spray foam insulation applied to a ceiling and roof deck on a NW Florida job site' },
  { f: 'jobsite.jpg', c: 'On site — Your City', a: 'A Plus Insulation truck and equipment on a job site in Your City' },
] as const;

export const testimonials = [
  {
    author: 'Danielle W.',
    role: 'Your City, FL',
    rating: 5,
    quote:
      'They insulated our attic with spray foam and the difference was immediate — the house holds its cool and our power bill dropped. Professional crew, fair price.',
  },
  {
    author: 'Robert M.',
    role: 'Grand River, FL',
    rating: 5,
    quote:
      'Removed the old nasty insulation and blew in new. On time, cleaned up after themselves, no job too big or too small like they say.',
  },
  {
    author: 'Sheila T.',
    role: 'Chandler, FL',
    rating: 5,
    quote:
      'Honest, local, and did exactly what they promised. Highly recommend A Plus for anyone in Random County.',
  },
] as const;

/** Home-page "where we work" chips — a spread across the full service area. */
export const serviceAreaChips = [
  'Your City', 'Grand River', 'Sandy Creek', 'Chandler', 'Brookhaven', 'Fenwick Springs',
  'Bay City', 'Bay City Beach', 'Bluffton', 'Brixton', 'Port Sterling', 'Applewood',
  'Quinby', 'Capitol City', 'Crawford', 'Dorset', 'Easton', 'Brambleton',
] as const;

export const serviceAreaTowns = [
  { t: 'Your City', d: 'Home base. Our shop sits right in the middle of town, so most Your City estimates happen fast.' },
  { t: 'Sandy Creek & Grand River', d: 'East Random County, out toward the river — a straight run down the highway from the shop.' },
  { t: 'Grayson & Campton', d: 'North toward the Alabama line. We cover the whole top of the county.' },
  { t: 'Chandler & Brookhaven', d: 'West into the neighboring counties — Panhandle neighbors we work in regularly.' },
  { t: 'Ashford & Cottonwood', d: 'Just south and west of Your City — some of our shortest drives.' },
  { t: 'Melrose & Greenfield', d: 'North county farm country. Older homes up this way often have the most to gain from an attic top-up.' },
] as const;

/** Service area grouped by region — larger areas, with the towns in each. */
export const serviceAreas: { area: string; state: string; home?: boolean; towns: string[] }[] = [
  {
    area: 'Random County',
    state: 'Florida',
    home: true,
    towns: ['Your City', 'Sandy Creek', 'Grand River', 'Cottonwood', 'Grayson', 'Ashford', 'Melrose', 'Campton', 'Greenfield'],
  },
  {
    area: 'West Panhandle',
    state: 'Florida',
    towns: ['Chandler', 'Brookhaven', 'Fenwick Springs', 'Verona', 'Pineville', 'Westbrook'],
  },
  {
    area: 'Gulf Coast & river country',
    state: 'Florida',
    towns: ['Bay City', 'Bay City Beach', 'Lynnwood', 'Bluffton', 'Brixton', 'Port Sterling', 'Applewood', 'Willowbrook'],
  },
  {
    area: 'Capitol City & the Big Bend',
    state: 'Florida',
    towns: ['Capitol City', 'Quinby', 'Haverford', 'Chatham', 'Crawford', 'Midvale'],
  },
  {
    area: 'South Alabama',
    state: 'Alabama',
    towns: ['Dorset', 'Easton', 'Oakridge', 'Glenville', 'Stanton', 'Hartwell'],
  },
  {
    area: 'Southwest Georgia',
    state: 'Georgia',
    towns: ['Brambleton', 'Donaldson', 'Clifton'],
  },
] as const;

/** Home FAQ — real search queries (keyword plan); also feeds FAQPage JSON-LD. */
export const faqs = [
  {
    q: 'Why is my electric bill so high?',
    a: 'In the Panhandle, the number-one culprit is attic heat. An under-insulated attic can top 130°F on a summer afternoon, and your AC fights it all day long. Air leaks and thin insulation let that heat pour into the house. A free assessment tells you in about twenty minutes whether your attic is the problem.',
  },
  {
    q: 'Is spray foam insulation worth it?',
    a: "For attics and new construction, usually yes: it air-seals and insulates in one step, and the comfort difference is immediate. It costs more up front. We'll tell you honestly when blown-in gets you most of the benefit for less.",
  },
  {
    q: 'Is spray foam insulation good in Florida?',
    a: "Yes — humidity is the reason. Foam is an air barrier, so it keeps muggy outdoor air out of your attic and off your ductwork. Installed right, with venting and inspection access handled, it's one of the best upgrades a Panhandle home can get.",
  },
  {
    q: 'What R-value is required in Florida?',
    a: 'Florida code calls for R-30 to R-38 in attics, and R-38 is the sweet spot for most homes in our climate zone. Many older Random County homes measure R-11 or less — that gap is where the savings are.',
  },
  {
    q: 'Does attic insulation help in summer?',
    a: 'Summer is when it works hardest. Insulation slows the heat radiating down from a hot roof into your living space, so the AC cycles less and rooms stay evener. Air sealing plus insulation can save around 15% on heating and cooling costs, per ENERGY STAR.',
  },
  {
    q: 'How often should insulation be replaced?',
    a: "Good insulation can last decades — but not if it's been wet, compressed, or visited by pests. If your home is 20+ years old and the bills keep climbing, it's worth having the attic measured. We check depth and condition for free.",
  },
  {
    q: 'Is blown-in insulation better than batts?',
    a: "In attics, usually — loose fill flows around joists, wires, and odd framing, so there are no gaps. Batts shine in open walls during construction or a remodel. We'll recommend whichever fits your house, not whichever we feel like selling.",
  },
] as const;

/** About page. */
export const about = {
  hero: {
    eyebrow: 'About',
    title: 'Your Local Insulation Experts in Your City, Florida',
    lead: 'Family-run since 2006. A Plus Insulation has spent two decades keeping Random County homes comfortable and efficient — one honest job at a time.',
  },
  intro: [
    'A Plus Insulation is a family-owned insulation contractor based in Your City, Florida. Since 2006 we have helped homeowners and builders across Random County and the Panhandle make their homes more comfortable and far more efficient.',
    'We install every major type of insulation — spray foam, blown-in, batt and roll, and radiant barrier — and we handle removal and replacement of old or damaged material. Whatever the project, we show up on time, do clean work, and stand behind it.',
  ],
  values: [
    { i: 'shield-check', t: 'Licensed & insured', d: 'Fully covered so you never carry the risk.' },
    { i: 'home', t: 'No job too big or too small', d: 'From a single attic to a whole rebuild.' },
    { i: 'leaf', t: 'Efficiency first', d: 'Right materials, right R-value for our climate.' },
  ],
  story: [
    'A Plus Insulation started in 2006 with a simple idea: do the work right, quote a fair number, and let the results speak for themselves. Two decades later we’re still family-run and still working out of our home base in Your City — the same county we started in.',
    'That matters more than it sounds. When your insulation contractor lives where you work, the job isn’t done when the invoice is paid. We run into our customers at the grocery store and the ball field, and every attic we insulate carries our name for the next twenty years.',
  ],
  commitments: [
    { t: 'Show up when we say', d: 'You get a time, not a four-hour window. If anything changes, you hear it from us first.' },
    { t: 'Explain options in plain English', d: 'Spray foam, blown-in, batts — we lay out what each one does for your house and what it costs, without the jargon.' },
    { t: 'Flat written numbers', d: 'Your estimate is itemized and in writing. The number we quote is the number you pay.' },
    { t: 'Leave it cleaner than we found it', d: 'We haul off the mess, old insulation included. You should only notice the comfort, not the job.' },
  ],
  details: [
    { t: 'Cash & all major cards', d: 'Pay however works for you — cash and all major cards accepted.' },
    { t: 'ASL-proficient', d: 'Deaf and hard-of-hearing homeowners are welcome to work with us directly in American Sign Language.' },
    { t: 'Free estimates', d: 'Every estimate is free, written, and itemized — no pressure, no obligation.' },
  ],
} as const;

/** Per-page SEO — titles + meta descriptions preserved from the keyword plan. */
export const seo = {
  home: {
    title: 'Insulation Contractor in Your City, FL | A Plus Insulation',
    description:
      'Spray foam, blown-in & batt insulation for Random County homes. A Plus Insulation in Your City, FL — free estimates. Call (850) 555-0100.',
  },
  services: {
    title: 'Insulation Services in Your City, FL | Spray Foam & More',
    description:
      'Attic insulation services in Your City, FL: spray foam, blown-in, batt & roll, radiant barrier, removal & replacement. Free estimates in Random County.',
  },
  about: {
    title: 'About A Plus Insulation | Your City, FL Insulation Pros',
    description:
      'Local, family-run insulation contractor in Your City, FL. Licensed & insured, serving Random County homeowners with honest work and fair prices.',
  },
  serviceArea: {
    title: 'Service Area | Insulation in Random County & NW Florida',
    description:
      'A Plus Insulation serves Your City, Sandy Creek, Grayson, Chandler, Brookhaven, Cottonwood, Grand River, Melrose & the NW Florida Panhandle. Free estimates.',
  },
  contact: {
    title: 'Free Insulation Estimate | A Plus Insulation Your City FL',
    description:
      'Get a free insulation estimate in Your City, FL. Call A Plus Insulation at (850) 555-0100 or send a message — we serve all of Random County.',
  },
} as const;
