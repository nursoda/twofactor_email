# Changelog
Notable changes in [changelog format](https://keepachangelog.com/),
project adheres to [Semantic Versioning](https://semver.org/).

This is the legacy version of the twofactor_email app for Nextcloud.
The new version lacks translation, please help to integrate it, see
https://github.com/datenschutz-individuell/twofactor_email/issues/6

## 2.8.8 (2026-04-22)

### Added

- Italian translation (@dsibaud)

## 2.8.7 (2026-04-14)

### Security

- Update dependencies to fix Axios security issue

## 2.8.6 (2026-04-03)

### Fixed

- Fixed issue #398 (zero-byte l10n/pl.json causing log warnings)

## 2.8.5 (2026-02-11)

### Changed

- Update Axios (see https://github.com/advisories/GHSA-43fc-jf86-j433)

## 2.8.4 (2026-01-26)

### Added

- Support for Nextcloud 33
- Support for PHP 8.5

## 2.8.3 (2025-11-30)

### Added

- Polish translation (@ayetee-re)

## 2.8.2 (2025-09-14)

### Security

- Update vulnerable dependencies (form-date, axios)
  vue2 is not vulnerable but unsupported. Please test and switch to v3.

## 2.8.1 (2025-08-29)

### Added

- Support for Nextcloud 32

This should be the last v2 release since the v3 is in beta testing for NC32.
Once released, an app update should migrate all users to v3. Please read the v3 README.
Probably not all languages will be avalilable upon release – volunteers needed.

## 2.8.0 (2025-03-16)

### Added

- Support for Nextcloud 29 to 31
- Support for PHP 8.4

### Removed

- Support for Nextcloud 24 to 28

## 2.7.4 (2023-11-06)

### Added

- Support for Nextcloud 28 (tested against beta1)
- Support for PHP 8.3

## 2.7.3 (2023-05-20)

### Added

- Support for Nextcloud 27 (tested against RC1)

## 2.7.2 (2023-03-04)

### Added

- Support for Nextcloud 26 (tested against RC1)
- Support for PHP 8.2

### Removed

- Support for Nextcloud 22 and 23
- Support for PHP 7.4

None of these recommended changes have been implemented yet:
https://github.com/nextcloud/server/issues/34692

## 2.7.1 (2022-10-16)

### Changed

- Fix Russian translation (Artyom)
- Support for Nextcloud 25 (tested against RC5)

Until further notice, this v2 branch is maintained as legacy.
Volunteers needed for the ongoing v3 re-write based on twofactor_totp.

## 2.7.0 (2022-09-20)

### Added

- Brazilian Portuguese translation (José A. Marteline Cavalcante)

### Changed

- correct light/dark icons

### Removed

- Support for PHP 7.3

## 2.6.0 (2022-09-04)

### Added

- Support for Nextcloud 25 (tested against beta 4)

### Changed

- material-design-icon as app icon, avoid to use it in-app
- replace verification by authentication where applicable

### Removed

- Support for Nextcloud 21

## 2.5.0 (2022-06-25)

### Added

- Turkish translation (@ersen0)

## 2.4.0 (2022-05-11)

### Added

- French translation (@ArchaicHammer)

## 2.3.0 (2022-04-15)

### Added

- Russian translation (@jensaymoo)

## 2.2.0 (2022-04-05)

### Added

- Support for Nextcloud 24 (tested against beta 2)
- Support for PHP 8.1
- German app description

### Changed

- Don't show email address in 2FA
- Re-add submit button in 2FA

### Removed

- Support for Nextcloud 19 and 20
- Support for PHP 7.2

### Security

- Update libraries

## 2.1.1 (2021-09-28)

### Added

- Support for Nextcloud 23

### Changed

- UI: new app icon, rephrase strings

## 2.1.0 (2021-09-11)

Note: Version 2.1.0 (store) = 2.0.1 (GitHub)

### Added

- Support for Nextcloud 22

## 2.0.0 (2020-12-23)

### Added

- Support for Nextcloud 21
- Support for PHP 8.0
- Static code analysis and code standard checks

### Removed

- Support for Nextcloud 18
- Support for PHP 7.1
