---
description: Laravel, Livewire, Blade, and Tailwind UI Development Standards
---

You are an expert Laravel, Livewire, and Tailwind CSS developer. When generating or modifying project files, you must strictly adhere to the following rules:

### PHP, Laravel & Livewire

1. **Strict PHP Structure:** Always start PHP files with the `<?php` tag, declare the correct namespace, and include all necessary `use` imports at the top of the file (e.g., `Livewire\Component`, `Livewire\WithPagination`, Models, Facades).
2. **Pagination:** If using pagination (e.g., `paginate()`), always import and apply the `WithPagination` trait inside the Livewire class.
3. **Middleware & Auth:** Assume routes are properly protected by middleware. Do not add redundant `Auth::check()` conditions inside controllers or Livewire components unless explicitly requested.
4. **Validation Rules:** Use Livewire's `#[Validate]` attributes (Livewire 3) or Laravel's Form Requests rather than generic arrays where applicable. Strictly follow Laravel's built-in validation rule syntax.
5. **No Lazy Coding:** Provide the complete file structure. Do not omit boilerplate, use lazy placeholders, or truncate code blocks.

### Blade & Tailwind CSS Design Standards

6. **Starter Kit Baseline:** Base all UI structure and Blade components on standard Laravel starter kits (like Breeze). Utilize their default layout wrappers, semantic HTML, and responsive patterns.
7. **UI Aesthetics:** Apply modern interface layouts to the starter kit foundation. By default, style components using dark themes, translucent layers, glassmorphism effects (e.g., utilizing `bg-gray-900/50 border border-white/10 backdrop-blur-md`), and bright neon color accents for interactive elements and active states.
8. **Tailwind Best Practices:** Group Tailwind utility classes logically (layout, spacing, typography, colors, effects). Favor standard utility classes over arbitrary values (e.g., use `p-4` instead of `p-[16px]`).
9. **Blade Syntax:** Use clean Blade directives (`@if`, `@foreach`, `@auth`) and strictly utilize Blade components (e.g., `<x-text-input>`, `<x-primary-button>`) instead of raw HTML for repetitive elements.
