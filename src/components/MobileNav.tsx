import { useEffect, useState } from 'react';
import { createPortal } from 'react-dom';
import { Menu, X, Phone } from 'lucide-react';

type Item = { label: string; href: string };

export default function MobileNav({
  items,
  phone,
  phoneHref,
  ctaHref,
  ctaLabel,
}: {
  items: readonly Item[];
  phone: string;
  phoneHref: string;
  ctaHref: string;
  ctaLabel: string;
}) {
  const [open, setOpen] = useState(false);

  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : '';
    return () => {
      document.body.style.overflow = '';
    };
  }, [open]);

  return (
    <div className="lg:hidden">
      <button
        type="button"
        onClick={() => setOpen(true)}
        className="grid size-11 place-items-center rounded-full bg-petrol text-cream"
        aria-label="Open menu"
      >
        <Menu className="size-5" aria-hidden />
      </button>

      {open &&
        typeof document !== 'undefined' &&
        createPortal(
          <div className="fixed inset-0 z-50 flex flex-col bg-canvas" role="dialog" aria-modal="true">
          <div className="flex items-center justify-between px-5 py-4">
            <span className="font-display text-xl font-semibold text-ink">Menu</span>
            <button
              type="button"
              onClick={() => setOpen(false)}
              className="grid size-11 place-items-center rounded-full bg-ink/5 text-ink"
              aria-label="Close menu"
            >
              <X className="size-5" aria-hidden />
            </button>
          </div>
          <nav className="flex flex-col gap-1 px-4">
            {items.map((item) => (
              <a
                key={item.href}
                href={item.href}
                className="rounded-2xl px-4 py-4 font-display text-3xl font-semibold text-ink transition-colors hover:bg-ink/5"
                onClick={() => setOpen(false)}
              >
                {item.label}
              </a>
            ))}
          </nav>
          <div className="mt-auto grid gap-3 p-5">
            <a href={ctaHref} className="btn btn-coral w-full" onClick={() => setOpen(false)}>
              {ctaLabel}
            </a>
            <a href={`tel:${phoneHref}`} className="btn btn-outline w-full">
              <Phone className="size-4" aria-hidden /> {phone}
            </a>
          </div>
          </div>,
          document.body,
        )}
    </div>
  );
}
