---
description: Strict backend logic rules for PHP, Laravel Controllers, and Livewire classes.
---

1. Always start the file with the <?php tag.
2. Always declare the correct namespace at the top of the file.
3. Always include all necessary 'use' imports (e.g., Livewire\Component, Livewire\WithPagination, Models, Facades).
4. If using pagination (e.g., paginate()), you MUST import and apply the WithPagination trait inside the class.
5. Assume routes are properly protected by middleware. Do not add redundant Auth::check() conditions inside controllers or Livewire components.
6. Provide the complete file structure. Do not omit boilerplate, use lazy placeholders, or truncate code blocks.
