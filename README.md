# Laravel Find

[![Latest Version on Packagist](https://img.shields.io/packagist/v/indracollective/laravel-artisan-find.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-artisan-find)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-artisan-find/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/indracollective/laravel-artisan-find/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-artisan-find/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/indracollective/laravel-artisan-find/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/indracollective/laravel-artisan-find.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-artisan-find)

**Quickly discover and build Laravel artisan commands through guided questioning and intelligent exploration.**

Laravel Find transforms the way you work with artisan commands by providing an interactive, guided interface that helps you discover, understand, and build commands with confidence. Inspired by the Socratic tradition of learning through inquiry, this package uses thoughtful questioning to lead you to the exact command you need.

![Demo](https://github.com/indracollective/laravel-artisan-find/raw/8b914752b56652fa2a08103d36346a84c1af2589/docs/demo.gif)

## Philosophy

Traditional command-line interfaces require you to know exactly what you're looking for. Laravel Find flips this approach by:

- **Discovering through exploration** - Browse commands by type, vendor, or search interactively
- **Learning through guidance** - See command descriptions, arguments, and options before committing
- **Building with confidence** - Preview your complete command before execution
- **Accelerating learning** - Speeds up discovery and usage of artisan commands while building your own knowledge of them

## Features

- 🔍 **Smart Command Discovery** - Interactive search with real-time filtering
- 📝 **Interactive Command Building** - Guided prompts for arguments and options
- 📋 **Clipboard Integration** - Copy completed commands directly to your clipboard
- 🎯 **Search Prefilling** - Start with a specific search term: `php artisan find make:model`
- 👀 **Preview Before Copy** - See exactly what will be copied before committing
- 🏷️ **Vendor Detection** - Automatically categorizes commands by their source (Laravel, Livewire, Filament, etc.)
- ⚡ **Zero Configuration** - Works out of the box with any Laravel application

## Installation

You can install the package via composer:

```bash
composer require --dev indracollective/laravel-artisan-find
```

The package will automatically register itself via Laravel's package discovery.

## Usage

### Basic Usage

Simply run the find command to start the interactive interface:

```bash
php artisan find
```

Or prefill with a search term to jump straight to relevant commands:

```bash
php artisan find controller
```

### How It Works

1. **Interactive Discovery**: Search through all available commands with real-time filtering
2. **Guided Selection**: Choose your command from intelligently filtered suggestions
3. **Build Your Command**: Follow guided prompts for required arguments and optional parameters
4. **Preview & Copy**: Review your complete command, then copy it to clipboard for immediate use


## Usage Examples

### Quick Discovery
Start typing and watch the list filter in real-time:

```bash
php artisan find
# Type "migr" to see: migrate, migrate:fresh, migrate:rollback, etc.
```

### Targeted Search
Jump directly to commands you know you need:

```bash
php artisan find controller    # Shows all controller-related commands
php artisan find queue         # Shows all queue-related commands
php artisan find test          # Shows testing commands
```

### Vendor-Specific Commands
Discover commands from your installed packages:

```bash
php artisan find filament      # Shows Filament commands
php artisan find livewire      # Shows Livewire commands
php artisan find pest          # Shows Pest testing commands
```

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
