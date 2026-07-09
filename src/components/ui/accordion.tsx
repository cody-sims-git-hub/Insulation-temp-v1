import * as React from 'react';
import * as AccordionPrimitive from '@radix-ui/react-accordion';
import { Plus, Minus } from 'lucide-react';
import { cn } from '@/lib/utils';

/** shadcn-style Accordion, restyled to the A Plus spec-sheet system. */
const Accordion = AccordionPrimitive.Root;

const AccordionItem = React.forwardRef<
  React.ElementRef<typeof AccordionPrimitive.Item>,
  React.ComponentPropsWithoutRef<typeof AccordionPrimitive.Item>
>(({ className, ...props }, ref) => (
  <AccordionPrimitive.Item
    ref={ref}
    className={cn(
      'mb-2 rounded-2xl px-4 transition-colors last:mb-0 data-[state=open]:bg-petrol/[0.06] sm:px-5',
      className,
    )}
    {...props}
  />
));
AccordionItem.displayName = 'AccordionItem';

const AccordionTrigger = React.forwardRef<
  React.ElementRef<typeof AccordionPrimitive.Trigger>,
  React.ComponentPropsWithoutRef<typeof AccordionPrimitive.Trigger>
>(({ className, children, ...props }, ref) => (
  <AccordionPrimitive.Header className="flex">
    <AccordionPrimitive.Trigger
      ref={ref}
      className={cn(
        'group flex flex-1 items-center justify-between gap-5 py-5 text-left text-lg font-bold text-ink transition-colors hover:text-petrol [&[data-state=open]]:text-petrol',
        className,
      )}
      {...props}
    >
      {children}
      <span className="relative grid size-8 shrink-0 place-items-center rounded-full bg-ink/5 text-ink transition-colors group-hover:bg-petrol/15 group-hover:text-petrol group-data-[state=open]:bg-petrol group-data-[state=open]:text-cream">
        <Plus className="size-4 group-data-[state=open]:hidden" aria-hidden />
        <Minus className="hidden size-4 group-data-[state=open]:block" aria-hidden />
      </span>
    </AccordionPrimitive.Trigger>
  </AccordionPrimitive.Header>
));
AccordionTrigger.displayName = 'AccordionTrigger';

const AccordionContent = React.forwardRef<
  React.ElementRef<typeof AccordionPrimitive.Content>,
  React.ComponentPropsWithoutRef<typeof AccordionPrimitive.Content>
>(({ className, children, ...props }, ref) => (
  <AccordionPrimitive.Content
    ref={ref}
    className="overflow-hidden data-[state=closed]:animate-[acc-up_0.2s_ease] data-[state=open]:animate-[acc-down_0.2s_ease]"
    {...props}
  >
    <div className={cn('max-w-2xl pb-6 pr-10 text-[0.95rem] leading-relaxed text-ink-soft', className)}>{children}</div>
  </AccordionPrimitive.Content>
));
AccordionContent.displayName = 'AccordionContent';

export { Accordion, AccordionItem, AccordionTrigger, AccordionContent };
