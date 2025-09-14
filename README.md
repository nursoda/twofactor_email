# Please switch to new "v3" repo

In 2024, this app wasn't updated for a while and left admins and their users in an uncomfortable situation. I am sorry for that and try not to let that happen again. This app was never and is not abandoned. But THIS version 2.x ("v2") repo now merely is in a feature freeze state. I will just make sure it's secure¹ and works for officially supported versions up to 31 as long as they are officially supported. For smooth transition, I released version 2.8.2 that still works with the old code on Nextcloud 32. But it uses quite a lot of deprecated APIs (and old dependencies) and will not work in 33 without a major overhaul.

I'll put all effort in releasing its successor, twofactor_email 3.x ("v3"). It lives in my [company's repository](https://github.com/datenschutz-individuell/twofactor_email). It's fully functional and tested by me. It should be production ready, but you should do your own tests. It lacks translation though. Also, the switch to vue3 will only happen after [feature freeze](https://github.com/nextcloud-libraries/nextcloud-vue/issues/6106#issuecomment-3287956365) of [nextcloud-vue](https://github.com/nextcloud-libraries/nextcloud-vue). I don't make promises on when a final release including translation will be released. Instead of asking for ETA, please ask me how you may help polish v3.

___
*¹Security: I am aware that this app has npm security warnings when building it. This in not due to my code but due to Nextcloud dependencies still relying on vue2, which is EOL since end of 2023 (and that EOL was annonced more than a year before that). When resolving dependencies, packages are used that do have known issues. Most of them are development dependencies "only" (meaning that potentially vulnerable code is not in the build code, but only used when building it) - with one notable exception: vue2.*
___

# Two-Factor Email Provider for Nextcloud

[Nextcloud](https://nextcloud.com/) supports web logins with [two factor authentication](https://en.wikipedia.org/wiki/Multi-factor_authentication#Factors) (2FA). To support a certain type of 2nd factor, an add-on server-app "2FA provider" must be installed. This is the current Two-Factor Email Provider for Nextcloud (see below).

It kicks in after the primary authentication stage (typically username and password). It challenges the user to enter a 6-digit authentication code (aka one-time password, OTP) - a code that is randomly generated and sent to the user's primary email address by this [Nextcloud App (category Security)](https://apps.nextcloud.com/categories/security).

Currently this app must be installed by an admin and must be enabled by the user. It currently uses the primary email address set in 'Personal info' and cannot be activated if none is set there. There is an issue that argues that using the primary notification address poses a security risk (to be discussed).

It currently cannot be used on first login when two-factor authentication is enforced (not implemented yet). It might be enhanced to enable admins to enforce 2FA via email for new (and existing?) users. Any pull requests or offers to help are welcome, please contact the maintainer (see [wiki](https://github.com/nursoda/twofactor_email/wiki/Developer-notes)).

The easiest way to install this app is to select "Apps" from the menu (as admin) and search for "two", then install it (which will retrieve it from the [App Store](https://apps.nextcloud.com/apps/twofactor_email)).
