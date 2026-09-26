# Pull Request: `dev` ➡️ `main`

## 🚀 Overview

This PR represents the completion of the core feature set for the Kencana Wisata form platform. It introduces a comprehensive administrative dashboard via Filament, a robust student-facing authentication and form submission portal using Livewire, and a fully branded public landing page.

## 🛠 Features & Improvements

### 1. Administrative Dashboard (Filament V3)
- Installed and configured the Filament admin panel (`/admin`).
- Developed full CRUD resources for **Schools**, **Users**, **Forms**, and **Submissions**.
- Implemented a custom dashboard featuring a **StatsOverview** (Total Forms, Active Forms, Total Users) and a **Submission Trend Chart**.
- Added single and batch **PDF Export** capabilities (using DOMPDF) to generate submission reports, fully branded with the new color scheme.

### 2. Student Portal & Form Engine (Livewire)
- Built a dedicated student authentication flow (Login/Register) utilizing native Tailwind and pure Livewire (bypassing Filament for frontend views).
- Designed a smart routing system: navigating to `/login` redirects authenticated students dynamically to their school's latest active form.
- Implemented **Cross-School Authorization**: Students are blocked (with a styled access denied banner) from accessing forms belonging to other schools.
- Added **Editable Submissions**: Students can update their previously submitted forms rather than being blocked.
- Developed the complex **Room Partner (`room_partner`)** logic: A custom Alpine.js-powered searchable checkbox list that prevents students from picking partners who have already been selected by others.
- Excluded the internal "Admin School" from the student registration dropdown.

### 3. UI, Branding & Typography
- Overhauled the Tailwind theme to use a custom premium palette: **Oxford Blue** (`#012862`), **Muted Gold** (`#d4b05c`), and **Deep Red** (`#9f1239`).
- Developed a fully-branded Indonesian **Landing Page** detailing company history, Google Maps links, and WhatsApp-integrated contact numbers.
- Unified the UI components (buttons, radios, checkboxes, hover/focus states, and `cursor-pointer` utility) across the public landing page, authentication views, and student form view.
- Refactored DOMPDF configurations to securely load the `Inter` font via Bunny Fonts for brand consistency.
- Updated `apple-touch-icon.png`, `favicon.ico`, and `favicon.svg` using the official brand webp.

### 4. Code Refactoring & Stability
- Refactored Livewire component layouts to use strongly-typed PHP 8 `#[Layout]` attributes instead of magic `->layout()` methods to resolve IDE warnings.
- Fixed Blade loop indexing (`$loop->index`).

## 📋 Checklist

- [ ] Tested all student authentication routes (register, login, logout).
- [ ] Verified cross-school form authorization checks.
- [ ] Verified Room Partner Alpine.js search and exclusion logic.
- [ ] Confirmed Filament dashboard metrics and widgets render without error.
- [ ] Tested PDF generation (individual and batch).
- [ ] Verified UI contrast and accessibility with the new Navy/Gold color palette.
