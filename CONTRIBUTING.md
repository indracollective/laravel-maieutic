# Contributing

Contributions are welcome and will be fully credited.

We accept contributions via Pull Requests on [GitHub](https://github.com/indracollective/laravel-maieutic).

## Pull Requests

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

## Running Tests

```bash
composer test
```

## Code Style

This project uses [Laravel Pint](https://github.com/laravel/pint) for code style formatting:

```bash
composer format
```

## Static Analysis

We use [PHPStan](https://phpstan.org/) for static analysis:

```bash
composer analyse
```

**Happy coding**!