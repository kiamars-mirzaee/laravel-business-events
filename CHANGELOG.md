# Changelog

All notable changes to `laravel-business-events` will be documented in this file.

## [1.0.0] - 2026-02-11

### Added
- Initial release
- Priority-based event processing
- Polymorphic model support
- Event status tracking (pending, processing, completed, failed)
- Background job processing
- Comprehensive documentation
- Unit tests

### Features
- `BusinessEvent` model for storing events
- `ProcessBusinessEvent` job for async processing
- `BusinessEventCreated` event
- `StoreBusinessEvent` listener
- Database migrations
- Service provider for auto-discovery

## [Unreleased]

### Planned
- Event retry mechanism
- Event archiving
- Dashboard for monitoring events
- Webhook support
