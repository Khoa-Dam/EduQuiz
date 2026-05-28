# Laravel Blade CRUD Checklist

## Purpose

Internal checklist for EduQuiz admin CRUD features.

## When to use

Use when building:

* Admin Course CRUD
* Admin Quiz CRUD
* Admin Question CRUD
* Admin Answer CRUD

## Checklist

### Route

* [ ] Resource route has correct prefix/name.
* [ ] Route is inside `auth` and `admin` middleware.
* [ ] Route names are clear.

### Controller

* [ ] Includes index/create/store/show/edit/update/destroy where needed.
* [ ] Validates input.
* [ ] Redirects after store/update/destroy.
* [ ] Uses success messages.
* [ ] Stays readable.

### Model

* [ ] Has `$fillable`.
* [ ] Has correct relationships.
* [ ] Uses eager loading when needed.

### View

* [ ] Has index page.
* [ ] Has create form.
* [ ] Has edit form.
* [ ] Has show page if needed.
* [ ] Forms include CSRF.
* [ ] Update form includes `@method('PUT')`.
* [ ] Delete form includes `@method('DELETE')`.
* [ ] Validation errors are displayed.
* [ ] Back links exist where useful.

## Output expected

CRUD works, UI is clear, and previous phases are not broken.
