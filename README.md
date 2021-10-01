# 2FA E-mail provider

This two factor authentication provider creates 6-digit random authentication codes and sends them to the user's primary email address.

Currently this app must be installed by an admin and must be enabled by the user. It might be enhanced to enable admins to enforce 2FA via email for new (and existing?) users.

It currently uses the primary email address set in 'Personal info' and cannot be acticvated if none is set there. There is an issue that argues that using the primary notification address poses a security rist (to be discussed).

It currently cannot be used on first login when two-factor authentication is enforced (not implemented yet).

Any pull requests or offers to help are welcome, please contact the maintainer (see [wiki](https://github.com/nursoda/twofactor_email/wiki/developer)).
