# Laravel Maieutic
*[my-YOO-tik]*

[![Latest Version on Packagist](https://img.shields.io/packagist/v/indracollective/laravel-maieutic.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-maieutic)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-maieutic/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/indracollective/laravel-maieutic/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-maieutic/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/indracollective/laravel-maieutic/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/indracollective/laravel-maieutic.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-maieutic)

**Quickly discover and build Laravel artisan commands through guided questioning and intelligent exploration.**

Laravel Maieutic transforms the way you work with artisan commands by providing an interactive, guided interface that helps you discover, understand, and execute commands with confidence. Named after the Socratic method of inquiry, this package uses thoughtful questioning to lead you to the exact command you need.

## Philosophy

Traditional command-line interfaces require you to know exactly what you're looking for. Laravel Maieutic flips this approach by:

- **Discovering through exploration** - Browse commands by type, vendor, or search interactively
- **Learning through guidance** - See command descriptions, arguments, and options before committing
- **Building with confidence** - Preview your complete command before execution
- **Accelerating learning** - Speeds up discovery and usage of artisan commands while building your own knowledge of them

## Features

- 🔍 **Smart Command Discovery** - Search, browse by namespace, or explore by vendor
- 📝 **Interactive Command Building** - Guided prompts for arguments and options
- 👀 **Preview Before Execute** - See exactly what will run before committing
- 🎯 **Intelligent Filtering** - Find commands by partial names or descriptions
- 🏷️ **Vendor Detection** - Automatically categorizes commands by their source (Laravel, Livewire, Filament, etc.)
- ⚡ **Zero Configuration** - Works out of the box with any Laravel application

## Installation

You can install the package via composer:

```bash
composer require indracollective/laravel-maieutic
```

The package will automatically register itself via Laravel's package discovery.

## Usage

### Basic Usage

Simply run the maieutic command to start the interactive interface:

```bash
php artisan maieutic
```

### How It Works

1. **Choose Your Approach**: Search directly, browse by command type (namespace), or explore by vendor
2. **Select Your Command**: Use interactive search or browse through categorized lists
3. **Build Your Command**: Follow guided prompts for required arguments and optional parameters
4. **Preview & Execute**: Review your complete command before running it

### Example Session

```
┌ Laravel Maieutic ──────────────────────────────────────────┐
│ How would you like to find commands?                       │
│ › Search all commands directly                             │
│   Browse by command type (8 types found)                  │
│   Browse by vendor (5 vendors found)                      │
│   Exit                                                     │
└────────────────────────────────────────────────────────────┘

┌ Search all commands: ────────────────────────────────────────┐
│ make                                                  │
│ › make:model - Create a new Eloquent model class            │
│   make:controller - Create a new controller class           │
│   make:migration - Create a new migration file              │
│   make:seeder - Create a new seeder class                   │
└──────────────────────────────────────────────────────────────┘

📝 This command requires some arguments:
┌ * Name: ─────────────────────────────────────────────────────┐
│ User                                                         │
└──────────────────────────────────────────────────────────────┘

┌ Select any options you'd like to include: ──────────────────┐
│ ◻ migration (Create a new migration file for the model)     │
│ ◻ factory (Create a new factory for the model)              │
│ ◻ seeder (Create a new seeder for the model)                │
│ ◻ controller (Create a new controller for the model)        │
│ ◻ resource (Indicates if the generated controller should be │
│   a resource controller)                                     │
└──────────────────────────────────────────────────────────────┘

📋 Command Preview:
   php artisan make:model User --migration --factory

┌ Execute this command? ───────────────────────────────────────┐
│ › Yes / No                                                   │
└──────────────────────────────────────────────────────────────┘
```

## Command Discovery Methods

### 1. Direct Search
Perfect when you have a rough idea of what you're looking for. Search across all command names and descriptions simultaneously.

### 2. Browse by Namespace (Command Type)
Commands are automatically grouped by their namespace:
- `make` - All generator commands
- `migrate` - Database migration commands
- `queue` - Queue management commands
- `route` - Routing commands
- And many more...

### 3. Browse by Vendor
Commands are intelligently categorized by their source:
- `laravel` - Core Laravel commands
- `livewire` - Livewire commands
- `filament` - Filament commands
- `spatie` - Spatie package commands
- `app` - Your application commands
- And others...

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or 12.0
- Terminal that supports Laravel Prompts

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Shea Dawson](https://github.com/indracollective)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
