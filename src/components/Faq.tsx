import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';

type QA = { q: string; a: string };

/** Homepage FAQ accordion. Content mirrors the FAQPage JSON-LD in the layout. */
export default function Faq({ items }: { items: readonly QA[] }) {
  return (
    <Accordion type="single" collapsible className="border-t-2 border-line">
      {items.map((item, i) => (
        <AccordionItem key={i} value={`faq-${i}`}>
          <AccordionTrigger>{item.q}</AccordionTrigger>
          <AccordionContent>{item.a}</AccordionContent>
        </AccordionItem>
      ))}
    </Accordion>
  );
}
