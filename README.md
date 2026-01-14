# TaskForge

TaskForge is a Laravel-based task management application built as an **early architectural learning and experimentation project**.

It explores building a relatively feature-rich application (authentication, collaboration, filtering, UI components) and now primarily serves as a **reflection point** on architectural decisions, trade-offs, and lessons learned.

This repository is intentionally kept public in its current state as an **architectural experiment**, not as a reference or recommended implementation.

---

## Project Status

⚠️ **This project is frozen and should not be used as an architectural reference.**

TaskForge should be viewed strictly as:
- an exploratory build
- a place where ideas were tried
- a reference for architectural mistakes and lessons learned

For a clean, idiomatic Laravel reference project, see **LaraNote**, which intentionally applies the lessons outlined below.

---

## Key Features

TaskForge includes a broad but inconsistently implemented feature set, typical of an exploratory task management build:

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

This section documents **lessons learned** during development and highlights architectural decisions I would explicitly avoid today.

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

This repository is intentionally **not deleted or rewritten**, despite its flaws.

It represents:
- a learning phase
- architectural exploration
- and growth as a developer

---

## License

TaskForge is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

