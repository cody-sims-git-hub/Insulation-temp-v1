/// <reference types="astro/client" />

// Fontsource packages are side-effect CSS imports with no bundled type
// declarations — declare them so `astro check` doesn't flag ts(2882).
declare module '@fontsource/*';
declare module '@fontsource-variable/*';
