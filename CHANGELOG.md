# Changelog

All notable changes to **penum-type** will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),  
and this project adheres to [Semantic Versioning](https://semver.org/).

---

## [v1.0.0]

### Added

- Initial `.d.ts` interface generation for PHP Enums with custom method define on config.
- Automatic grouping of all enum interfaces into a single export.
- Config file publishing via `php artisan vendor:publish --tag=penum-type`.
- Command `php artisan penum-type:generate` to generate the file
