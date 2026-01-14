# TaskForge

TaskForge is a Laravel-based task management application that was originally built as a **learning and experimentation project**.

It explores building a feature-rich application with authentication, collaboration, filtering, and UI components — and, importantly, serves as a **reflection point** on architectural decisions, trade-offs, and lessons learned.

This repository is intentionally kept public in its current state as an **architectural experiment**, not as a polished reference implementation.

---

## Project Status

⚠️ **This project is frozen and no longer under active development.**

TaskForge should be viewed as:
- an exploratory build
- a place where ideas were tried
- a reference for what *worked* and what *did not*

For a clean, idiomatic Laravel example, see my newer repositories (e.g. *LaraNote*), which apply the lessons outlined below.

---

## Key Features

TaskForge includes a wide range of features typically found in task management tools:

- User authentication & authorization
- Boards, tasks, collaborators, and tags
- Task status workflows
- Search and filtering
- Dashboard-style UI
- Responsive layout with Tailwind CSS

The feature set is intentionally broad and was used to explore Laravel, and UI-driven development.

---

## Technology Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade + Tailwind CSS
- **Build tooling:** Vite
- **Database:** SQLite (via Eloquent ORM)
- **Package management:** Composer & npm

---

## Architectural Reflection

This section documents **lessons learned** during development and what I would approach differently today.

### What Worked Well

- Gaining hands-on experience with Laravel’s ecosystem
- Exploring authorization logic and multi-user features
- Understanding how complexity grows in real applications

---

### What Went Wrong

In hindsight, several architectural issues became apparent:

- **Inconsistent project structure**
  - Multiple patterns were mixed (actions, controllers, services) without a clear boundary

- **Over-abstraction too early**
  - Domain folders and service-like classes were introduced before the fundamentals were fully solid

- **Blurred responsibilities**
  - Business rules appeared in controllers, requests, and helpers inconsistently

- **Validation and authorization scattered**
  - Some checks lived in FormRequests, others in controllers or actions

- **Code style drift**
  - Inconsistent naming, unused code, and partially implemented ideas accumulated over time

These issues made the codebase harder to reason about and review, despite working functionality.

---

### What I Would Do Differently Now

If rebuilding TaskForge today, I would:

- Start with **strict Laravel conventions** (controllers, policies, requests, models)
- Keep controllers thin and declarative
- Centralize authorization exclusively in policies
- Keep FormRequests focused on validation + authorization only
- Avoid introducing service layers until complexity *requires* them
- Prefer fewer features implemented cleanly over many features implemented inconsistently

These principles are applied in my newer projects.

---

## Installation & Setup (Optional)

TaskForge can still be run locally if desired:

```bash
git clone https://github.com/basdvreugd5/TaskForge.git
cd TaskForge
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

---

## Why This Repo Still Exists

This repository is intentionally **not deleted or rewritten**.

It represents:
- a learning phase
- architectural exploration
- and growth as a developer

---

## License

TaskForge is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

