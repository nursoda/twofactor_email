# Please switch to new "v3" repo

In 2024, this app wasn't updated for a while and left admins and their users in an uncomfortable situation. I am sorry for that and try not to let that happen again. This app was never and is not abandoned. But THIS version 2.x ("v2") repo now is deprecated, please upgrade to [v3](https://github.com/datenschutz-individuell/twofactor_email).

I will make sure v2 is secure¹ and works for officially supported versions up to 31 as long as they are officially supported. For smooth transition, I released version 2.8.x that still work with the old code even on Nextcloud 33. But it uses quite a lot of deprecated APIs (and old dependencies) si it is strongly recommended to switch to v3. All existing v2 functionality is there, and quite some translations are already integrated. Some users and myself are using it for more than a year now, so we released it non-beta in May, 2026.
___
*¹Security: I am aware that this app has npm security warnings when building it. This in not due to my code but due to Nextcloud dependencies still relying on vue2, which is EOL since end of 2023 (and that EOL was annonced more than a year before that). When resolving dependencies, packages are used that do have known issues. Most of them are development dependencies "only" (meaning that potentially vulnerable code is not in the build code, but only used when building it) - with one notable exception: vue2.*

*Version ceiling: `vue` and `vue-template-compiler` stay at 2.7.16 (the last Vue 2 release), `vue-loader` at 15.x (16+ requires Vue 3). The `^` ranges in `package.json` enforce this - do not widen them.*
___

# Two-Factor Email Provider for Nextcloud

[Nextcloud](https://nextcloud.com/) supports web logins with [two factor authentication](https://en.wikipedia.org/wiki/Multi-factor_authentication#Factors) (2FA). To support a certain type of 2nd factor, an add-on server-app "2FA provider" must be installed. This is the current Two-Factor Email Provider for Nextcloud (see below).

It kicks in after the primary authentication stage (typically username and password). It challenges the user to enter a 6-digit authentication code (aka one-time password, OTP) - a code that is randomly generated and sent to the user's primary email address by this [Nextcloud App (category Security)](https://apps.nextcloud.com/categories/security).

Currently this app must be installed by an admin and must be enabled by the user. It currently uses the primary email address set in 'Personal info' and cannot be activated if none is set there. There is an issue that argues that using the primary notification address poses a security risk (to be discussed).

It currently cannot be used on first login when two-factor authentication is enforced (not implemented yet). It might be enhanced to enable admins to enforce 2FA via email for new (and existing?) users. Any pull requests or offers to help are welcome, please contact the maintainer (see [wiki](https://github.com/nursoda/twofactor_email/wiki/Developer-notes)).

The easiest way to install this app is to select "Apps" from the menu (as admin) and search for "two", then install it (which will retrieve it from the [App Store](https://apps.nextcloud.com/apps/twofactor_email)).
