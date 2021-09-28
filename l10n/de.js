OC.L10N.register(
	"twofactor_email",
	{
	// appinfo/info.xml 
	"Two-Factor Email" : "Zwei-Faktor E-Mail",
	"Two-Factor Email Provider" : "Zwei-Faktor E-Mail Anbieter",
	"Two-Factor Authentication using email" : "Zwei-Faktor Authentifizierung per E-Mail",
	"This app allows users to set up email as a second factor for web logins. It requires that an email address is set in personal settings. It currently cannot be used on first login when two-factor authentication is enforced (not implemented yet)." : "Diese App ermöglicht es Benutzern, E-Mail als zweiten Faktor für Webanmeldungen einzurichten. Sie setzt voraus, dass eine E-Mail-Adresse in den persönlichen Einstellungen hinterlegt ist. Sie kann derzeit nicht für die erste Anmeldung verwendet werden, wenn die Zwei-Faktor-Authentifizierung erzwungen wird",

	// lib/Provider/Email.php
	"Email verification" : "E-Mail Bestätigung",
	"Send a code to the address set in your account" : "Sende einen Code an die im Benutzerkonto hinterlegte Adresse",

	// lib/Service/Email.php
	"Login with Two-Factor Email on %s" : "Anmeldung mit Zwei-Faktor Email auf %s",
	"Login attempt for account %s" : "Anmeldeversuch für Konto %s",
	"If you just tried to login, please enter this code: %s" : "Falls du eben versucht hast dich anzumelden, musst du diesen Code eingeben: %s",

	// src/components/GatewaySettings.vue
	"To be able to activate Two-Factor Email you need to set an email address in your user account first." : "Um Zwei-Faktor E-Mail aktivieren zu können musst du zunächst eine E-Mail-Adresse in deinem Benutzerkonto hinterlegen.",

	"Two-Factor Email is not activated. It may send codes to the email address set in your user account." : "Zwei-Faktor E-Mail ist nicht aktiviert. Es kann Codes an die in deinem Benutzerkonto hinterlegte E-Mail Adresse senden.",
	"Enable email verification" : "Code per E-Mail aktivieren",

	"The code entered did not match. A new code was sent. Please retry." : "Der eigegebene Code stimmte nicht. Ein weiterer Code wurde gesendet. Bitte nochmal probieren.",
	"A code has been sent to {emailAddress}. Please insert it here:" : "Ein Code wurde an {emailAddress} gesendet. Bitte hier eingeben:",
	"Verify code" : "Code überprüfen",
	"Cancel activation" : "Aktivierung abbrechen",

	"Two-Factor Email is active. Codes are sent to {emailAddress}." : "Zwei-Faktor E-Mail ist jetzt aktiv. Codes werden an {emailAddress} gesendet.",
	"Disable email verification" : "Code per E-Mail deaktivieren",

	// templates/error.php 
	"Error while sending the message. Please try again later or contact the administrator." : "Fehler beim Versenden der Nachricht. Bitte später nochmal probieren, oder den Administrator fragen."

	// templates/challenge.php
	"An code has been sent to %s. Please insert it here:" : "Ein Code wurde an %s gesendet. Bitte hier eingeben:",
	"Code sent by email" : "Per E-Mail gesendeter Code",
},
"");
