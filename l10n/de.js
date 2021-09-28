OC.L10N.register(
	"twofactor_email",
	{
	// appinfo/info.xml 
	"Two-Factor Email" : "Zwei-Faktor E-Mail",
	"Two-Factor Email Provider" : "Zwei-Faktor E-Mail Anbieter",
	"This app allows users to set up email as a second factor for web logins. It requires that an email address is set in 'Personal info'. It currently cannot be used on first login when two-factor authentication is enforced (not implemented yet)." : "Diese App ermöglicht es Benutzern, E-Mail als zweiten Faktor für Webanmeldungen einzurichten. Sie setzt voraus, dass eine E-Mail-Adresse in den persönlichen Einstellungen hinterlegt ist. Sie kann derzeit nicht für die erste Anmeldung verwendet werden, wenn die Zwei-Faktor-Authentifizierung erzwungen wird",

	// lib/Provider/Email.php
	"Email verification" : "E-Mail Bestätigung",
	"Send a code to your email address" : "Sende einen Code an deine E-Mail-Adresse",

	// lib/Service/Email.php
	"Login attempt for %s" : "Anmeldeversuch für %s",
	"Your two-factor authentication code is: %s" : "Dein Zwei-Faktor Anmelde-Code lautet: %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Gib diesen Code auf %s ein, falls du dich anmelden wolltest. Falls du das nicht warst kennt jemand deine E-Mail-Adresse oder deinen Benutzernamen – und dein Passwort!",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Du musst zuerst eine E-Mail-Adresse in 'Persönliche Informationen' hinterlegen.",

	"Enable Two-Factor Email" : "Zwei-Faktor E-Mail einschalten",

	"The entered code did not match. A new " : "Der eigegebene Code stimmte nicht. Ein weiterer ",
	"A " : "Ein ",
	"code has been sent to {emailAddress}." : "Code wurde an {emailAddress} gesendet.",
	"Verify code" : "Code bestätigen",
	"Cancel activation" : "Einschalten abbrechen",

	"Two-Factor Email is enabled. Codes are sent to {emailAddress}." : "Zwei-Faktor E-Mail ist eingeschaltet. Codes werden an {emailAddress} gesendet.",
	"Disable Two-Factor Email" : "Zwei-Faktor E-Mail ausschalten",

	// templates/error.php 
	"Error while sending the email. Please try again later or ask your administrator." : "Fehler beim Versenden der E-Mail. Bitte probiere es später nochmal oder frage deinen Administrator.",

	// templates/challenge.php
	"A code was sent to %s" : "Ein Code wurde an %s gesendet",
	"Enter authentication code" : "Anmelde-Code eingeben",
},
"");
