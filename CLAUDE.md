# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Sylius plugin that adds brand functionality to products. It allows merchants to:
- Assign brands to products
- Add brand logos/images
- Filter products by brand in admin

**Requirements:** PHP 8.2+, Sylius 2.0+, Symfony 6.4/7.4

## Code Standards

Follow clean code principles and SOLID design patterns when working with this codebase:
- Write clean, readable, and maintainable code
- Apply SOLID principles (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion)
- Use meaningful variable and method names
- Keep methods and classes focused on a single responsibility
- Favor composition over inheritance
- Write code that is easy to test and extend

### Testing Requirements
- Write unit tests for all new functionality (if it makes sense)
- Follow the BDD-style naming convention for test methods (e.g., `it_should_do_something_when_condition_is_met`)
- **MUST use Prophecy for mocking** - Use the `ProphecyTrait` and `$this->prophesize()` for all mocks, NOT PHPUnit's `$this->createMock()`
- **Form testing** - Use Symfony's best practices for form testing as documented at https://symfony.com/doc/current/form/unit_testing.html
  - Extend `Symfony\Component\Form\Test\TypeTestCase` for form type tests
  - Use `$this->factory->create()` to create form instances
  - Test form submission, validation, and data transformation
- Ensure tests are isolated and don't depend on external state
- Test both happy path and edge cases

## Development Commands

```bash
# Run all checks before committing
composer all

# Static analysis (PHPStan at max level)
composer analyse

# Code style check/fix (Easy Coding Standard using Sylius standards)
composer check-style
composer fix-style

# Unit tests
composer phpunit

# Run a single test
vendor/bin/phpunit tests/Path/To/YourTest.php
vendor/bin/phpunit --filter testMethodName

# Run test application for development
composer try
```

### PHPStan Configuration

PHPStan is configured in `phpstan.neon` with:
- **Analysis Level**: max (strictest)
- **Symfony Integration**: Uses console application loader (`tests/PHPStan/console_application.php`)
- **Doctrine Integration**: Uses object manager loader (`tests/PHPStan/object_manager.php`)
- **Exclusions**: `tests/Application/*`

### Test Application

The plugin includes a test Symfony application in `tests/Application/` for development and testing:
- Run `composer try` to start the test application
- Use standard Symfony commands for the test app
- **Sylius Backend Credentials**: Username: `sylius`, Password: `sylius`

## Bash Tools Recommendations

Use the right tool for the right job when executing bash commands:

- **Finding FILES?** → Use `fd` (fast file finder)
- **Finding TEXT/strings?** → Use `rg` (ripgrep for text search)
- **Finding CODE STRUCTURE?** → Use `ast-grep` (syntax-aware code search)
- **SELECTING from multiple results?** → Pipe to `fzf` (interactive fuzzy finder)
- **Interacting with JSON?** → Use `jq` (JSON processor)
- **Interacting with YAML or XML?** → Use `yq` (YAML/XML processor)

Examples:
- `fd "*.php" | fzf` - Find PHP files and interactively select one
- `rg "function.*validate" | fzf` - Search for validation functions and select
- `ast-grep --lang php -p 'class $name extends $parent'` - Find class inheritance patterns

## Architecture

### Core Domain Model

- `Brand` - Main entity with code, name, products collection, and images collection
- `BrandImage` - Images associated with a brand (logos, etc.)
- Products link to brands via `ProductTrait` which adds a `brand` ManyToOne relationship

### Integration Pattern

The plugin uses Sylius's trait/interface pattern for extending the Product entity:
- `ProductInterface` extends Sylius's ProductInterface with brand getter/setter
- `ProductTrait` provides the implementation with Doctrine ORM mapping
- Host applications must extend their Product entity with these

### Key Directories

- `src/Model/` - Domain entities (Brand, BrandImage) and traits for extending Product
- `src/Form/` - Symfony form types and extensions (including ProductTypeExtension for brand field)
- `src/Doctrine/ORM/` - Repositories and repository traits
- `src/Fixture/` - Sylius fixture integration for brands
- `src/Resources/config/` - Service definitions and routing
- `tests/Application/` - Full Sylius test application

### Resources (Sylius Resource Bundle)

Two resources are registered under `loevgaard_sylius_brand`:
- `brand` - The Brand entity
- `brand_image` - The BrandImage entity

Both can be customized via configuration (model, controller, repository, factory, form classes).

### Admin Integration

- Menu listener adds "Brands" item to Catalog section
- Grid configuration in `src/Resources/config/grids/`
- Product form extension adds brand autocomplete field
- Optional: Brand column on product grid (import `sylius_admin_product.yaml`)

### Events

- `loevgaard_sylius_brand.menu.admin.brand.form` - Customize Brand admin form menu

### Translations

Translation files in `src/Resources/translations/`:
- **Domains**: `messages`, `flashes`, `validators`
- **Languages**: English (en), German (de), French (fr), Spanish (es), Italian (it), Dutch (nl), Polish (pl), Danish (da), Swedish (sv), Norwegian (no), Finnish (fi)
- **Key prefix**: `loevgaard_sylius_brand.*`
  - `loevgaard_sylius_brand.ui.*` - UI labels
  - `loevgaard_sylius_brand.form.*` - Form field labels
  - `loevgaard_sylius_brand.brand.*` - Flash messages
