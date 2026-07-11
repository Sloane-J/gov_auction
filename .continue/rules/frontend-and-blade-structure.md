---
description: Frontend structure rules for Laravel Blade templates and UI components.
---

1. Base all UI structure and view files on standard Laravel starter kits (like Breeze).
2. Strictly utilize Blade components (e.g., <x-text-input>, <x-primary-button>, <x-modal>) instead of raw HTML for repetitive UI elements.
3. Use clean Blade directives (@if, @foreach, @auth, @error) instead of raw PHP tags.
4. Ensure proper semantic HTML nesting and mobile-first responsive layout patterns.
5. Provide the complete Blade file. Do not truncate the HTML structure or leave implementation up to the user.
