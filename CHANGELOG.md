# CHANGELOG
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## v0.2.0 - 2016-11-08
### Added
- `Year`, `Month`, `Date`, `Time`, `LocalDateTime` and `ZonedDateTime` are comparable from now on.
  Next methods were added to these types:
    - `compare()`
    - `greaterThan()`
    - `greaterThanOrEqual()`
    - `lessThan()`
    - `lessThanOrEqual()`
- Value objects were made serializable: `Year`, `Date`, `Time`, `LocalDateTime`, `ZonedDateTime`, `TimeZone`,
  `TimeZoneId`, `Offset`.

### Changed
- (BC Break) Dependency `litgroup/enumerable` was updated to `^0.6.0`.

## v0.1.1 - 2016-10-10
### Added
- Added shortcut factory `ZonedDateTime::nowUtc()` which returns current time in the UTC timezone.

## v0.1.0 - 2016-10-08
### Added
- Added `Time` value object. It represents time in the ISO-8601 calendar
  system (without time-zone).
- Added `Year` value object.
- Added `Month` value object.
- Added `Date` value object. It represents date in the ISO-8601 calendar
  system (without time-zone).
- Added interface `DateTime`.
- Added class `LocalDateTime`. (A date-time without a time-zone in the
  ISO-8601 calendar system, such as 2007-12-03T10:15:30).
- Added `TimeZone` and `TimeZoneId`.
- Added `TimeZones` - repository of time zones.
- Added `ZonedDateTime`.
- Added `Offset`.
- Added interface `Format\DateTimeFormatter`.
- Added interface `Format\DateTimeParser`.
- Added interface `Format\DateFormatter`.
- Added interface `Format\DateParser`.
- Added interface `Format\TimeFormatter`.
- Added interface `Format\TimeParser`.
- Added exception `Exception\FormatException`.
- Added `Format\SimpleDateFormatter` which makes formatting of date to the format `YYYY-MM-DD`.
- Added `Format\SimpleTimeFormatter` which makes formatting of time to the format `HH:mm:ss`.
- Added `Format\SimpleDateTimeFormatter` which makes formatting of time to the format `YYYY-MM-DD HH:mm:ss`.
- Added `Format\SimpleDateParser` which parses `Date` from a string representation of the format `YYYY-MM-DD`.
- Added `Format\SimpleTimeParser` which parses `Time` from a string representation of formats: `HH:mm` and `HH:mm:ss`.
- Added `Format\SimpleDateTimeParser` which parses date and time from a string representation of formats:
  `YYYY-MM-DD HH:mm:ss`.
- Added `Clock`.  A clock providing access to the current date and time using a time-zone.
