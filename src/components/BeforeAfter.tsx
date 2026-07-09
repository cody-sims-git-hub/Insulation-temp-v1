import { useRef, useState, useCallback } from 'react';
import { MoveHorizontal } from 'lucide-react';

type Props = {
  beforeSrc: string;
  afterSrc: string;
  beforeAlt: string;
  afterAlt: string;
  beforeLabel?: string;
  afterLabel?: string;
  beforeStat?: string;
  afterStat?: string;
  /** Optional color-grade overlays (e.g. thermal hot/cool). */
  beforeOverlay?: string;
  afterOverlay?: string;
};

/**
 * Before/after slider. Used here as an honest thermal comparison of the SAME
 * attic before and after air sealing + R-38 — labeled illustrative — which
 * frames comfort as a measurable temperature drop, the subject's own language.
 * Uses clip-path so neither image distorts at any slider position.
 */
export default function BeforeAfter({
  beforeSrc,
  afterSrc,
  beforeAlt,
  afterAlt,
  beforeLabel = 'Before',
  afterLabel = 'After',
  beforeStat,
  afterStat,
  beforeOverlay,
  afterOverlay,
}: Props) {
  const [pos, setPos] = useState(50);
  const ref = useRef<HTMLDivElement>(null);
  const dragging = useRef(false);

  const setFromClientX = useCallback((clientX: number) => {
    const el = ref.current;
    if (!el) return;
    const rect = el.getBoundingClientRect();
    const pct = ((clientX - rect.left) / rect.width) * 100;
    setPos(Math.max(2, Math.min(98, pct)));
  }, []);

  return (
    <div
      ref={ref}
      className="group relative aspect-[4/3] w-full touch-none select-none overflow-hidden rounded-[1.75rem] bg-ink shadow-lift"
      onPointerDown={(e) => {
        dragging.current = true;
        (e.target as HTMLElement).setPointerCapture?.(e.pointerId);
        setFromClientX(e.clientX);
      }}
      onPointerMove={(e) => dragging.current && setFromClientX(e.clientX)}
      onPointerUp={() => (dragging.current = false)}
      onPointerLeave={() => (dragging.current = false)}
    >
      {/* After (base layer, full width) */}
      <img src={afterSrc} alt={afterAlt} className="absolute inset-0 size-full object-cover" draggable={false} />
      {afterOverlay && <div className={`absolute inset-0 ${afterOverlay}`} aria-hidden />}
      <div className="pointer-events-none absolute bottom-3 right-3 z-10 flex items-center gap-2 rounded-full bg-petrol px-3.5 py-1.5">
        <span className="text-xs font-semibold uppercase tracking-wide text-cream">{afterLabel}</span>
        {afterStat && <span className="text-sm font-semibold text-honey">{afterStat}</span>}
      </div>

      {/* Before (same size, revealed via clip-path) */}
      <div className="absolute inset-0" style={{ clipPath: `inset(0 ${100 - pos}% 0 0)` }}>
        <img src={beforeSrc} alt={beforeAlt} className="absolute inset-0 size-full object-cover" draggable={false} />
        {beforeOverlay && <div className={`absolute inset-0 ${beforeOverlay}`} aria-hidden />}
      </div>
      <div className="pointer-events-none absolute bottom-3 left-3 z-10 flex items-center gap-2 rounded-full bg-ink/85 px-3.5 py-1.5">
        <span className="text-xs font-semibold uppercase tracking-wide text-cream">{beforeLabel}</span>
        {beforeStat && <span className="text-sm font-semibold text-coral-soft">{beforeStat}</span>}
      </div>

      {/* Handle */}
      <div className="pointer-events-none absolute inset-y-0 z-20 w-0.5 bg-cream" style={{ left: `${pos}%` }}>
        <span className="absolute left-1/2 top-1/2 flex size-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-cream text-ink shadow-lift">
          <MoveHorizontal className="size-5" aria-hidden />
        </span>
      </div>

      <label className="sr-only" htmlFor="ba-range">Reveal before / after</label>
      <input
        id="ba-range"
        type="range"
        min={2}
        max={98}
        value={pos}
        onChange={(e) => setPos(Number(e.target.value))}
        className="absolute inset-0 z-30 size-full cursor-ew-resize opacity-0"
        aria-label="Drag to compare before and after"
      />
    </div>
  );
}
