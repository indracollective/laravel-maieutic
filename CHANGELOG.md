# Changelog

All notable changes to `laravel-artisan-find` will be documented in this file.

## Roadmap

### Planned Features
- **ArtisanSuggest Command** - Natural language to Laravel command translation using Laravel Prism
  - Usage: `php artisan suggest "Create a new filament resource"`  
  - LLM-powered interpretation of natural language requests
  - Integration with Laravel Prism for accurate command suggestions
  - Smart context awareness for project-specific recommendations

## 2.0.0 - 2025-01-12

- **BREAKING:** Refactor command interface with single suggest prompt
- Add optional search argument for prefilling: `php artisan find make:model`
- Replace execution with clipboard integration - commands are copied, not executed
- Add elegant PHPDoc blocks with philosophical guidance theme
- Remove complex multi-step navigation in favor of streamlined search
- Update command signature back to `find` with search parameter support
- Improve real-time filtering with up to 500 command suggestions
- Enhanced user experience with preview and copy workflow

## 1.2.0 - 2025-01-09

- Change command signature from `?` to `m` for shell compatibility: `php artisan m`

## 1.1.0 - 2025-01-09

- Change command signature from `find` to `?` for simpler usage: `php artisan ?`
- Add pronunciation guide to README

## 1.0.0 - 2025-01-09

- Initial release
- Interactive artisan command discovery through guided questioning
- Smart command discovery with search, browse by namespace, or explore by vendor
- Interactive command building with guided prompts for arguments and options
- Preview commands before execution
- Intelligent filtering to find commands by partial names or descriptions
- Automatic vendor detection and categorization (Laravel, Livewire, Filament, etc.)
- Zero configuration - works out of the box with any Laravel application
- Support for PHP 8.2+ and Laravel 11/12
