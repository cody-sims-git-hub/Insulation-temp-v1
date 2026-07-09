import { useState } from 'react';
import { Check, Phone, Loader2 } from 'lucide-react';

type Props = {
  services: readonly string[];
  phone: string;
  phoneHref: string;
  /** CF Worker / form endpoint. Injected at build via PUBLIC_LEAD_ENDPOINT. */
  endpoint?: string;
};

const field =
  'mt-2 w-full rounded-xl border border-line bg-canvas px-4 py-3 text-ink transition-colors placeholder:text-muted/60 focus:border-petrol focus:outline-none focus:ring-2 focus:ring-petrol/20';
const labelText = 'text-sm font-semibold text-ink';

type State = 'idle' | 'sending' | 'sent' | 'error';

/**
 * Lead-capture form — the one "requires a db" path. Posts JSON to a Worker
 * endpoint when configured; otherwise fails gracefully to a call-us prompt so a
 * homeowner is never dropped silently.
 */
export default function QuoteForm({ services, phone, phoneHref, endpoint }: Props) {
  const [state, setState] = useState<State>('idle');

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    if (!endpoint) {
      setState('error');
      return;
    }
    setState('sending');
    const data = Object.fromEntries(new FormData(e.currentTarget).entries());
    try {
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      if (!res.ok) throw new Error(`Bad status ${res.status}`);
      setState('sent');
    } catch {
      setState('error');
    }
  }

  if (state === 'sent') {
    return (
      <div className="flex flex-col items-center gap-4 rounded-[1.75rem] bg-cream px-6 py-14 text-center shadow-soft">
        <span className="grid size-14 place-items-center rounded-full bg-petrol text-cream">
          <Check className="size-7" aria-hidden />
        </span>
        <h2 className="text-5xl text-ink">Request received</h2>
        <p className="max-w-sm text-ink-soft">
          Thanks — we’ll call you back within one business day to set up your free attic assessment. Need us sooner?
        </p>
        <a href={`tel:${phoneHref}`} className="btn btn-petrol mt-1">
          <Phone className="size-4" aria-hidden /> {phone}
        </a>
      </div>
    );
  }

  return (
    <form onSubmit={onSubmit} className="rounded-[1.75rem] bg-cream p-6 shadow-soft sm:p-8">
      <div className="grid gap-5">
        <div className="grid gap-5 sm:grid-cols-2">
          <label className="block">
            <span className={labelText}>Name</span>
            <input type="text" name="name" required autoComplete="name" className={field} placeholder="Jane Homeowner" />
          </label>
          <label className="block">
            <span className={labelText}>Phone</span>
            <input type="tel" name="phone" required autoComplete="tel" className={field} placeholder="(850) 000-0000" />
          </label>
        </div>
        <label className="block">
          <span className={labelText}>Email</span>
          <input type="email" name="email" autoComplete="email" className={field} placeholder="you@email.com" />
        </label>
        <label className="block">
          <span className={labelText}>Service needed</span>
          <select name="service" className={field} defaultValue="">
            <option value="">Not sure yet — help me decide</option>
            {services.map((s) => (
              <option key={s}>{s}</option>
            ))}
          </select>
        </label>
        <label className="block">
          <span className={labelText}>Project details</span>
          <textarea
            name="message"
            rows={4}
            className={field}
            placeholder="Age of home, what you’re noticing (high bills, hot rooms), rough square footage…"
          />
        </label>

        {state === 'error' && (
          <p className="rounded-xl bg-coral/15 px-4 py-3 text-sm text-ink">
            We couldn’t send that just now. Please call{' '}
            <a href={`tel:${phoneHref}`} className="font-semibold text-petrol underline underline-offset-2">
              {phone}
            </a>{' '}
            — a real person answers during business hours.
          </p>
        )}

        <button type="submit" className="btn btn-coral w-full sm:w-auto" disabled={state === 'sending'}>
          {state === 'sending' ? (
            <>
              <Loader2 className="size-4 animate-spin" aria-hidden /> Sending…
            </>
          ) : (
            'Request my free estimate'
          )}
        </button>
        <p className="text-sm text-muted">No spam, no obligation — just a written, itemized number.</p>
      </div>
    </form>
  );
}
