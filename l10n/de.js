OC.L10N.register(
	"twofactor_email",
	{
	// ADDITIONAL strings to be localized in appinfo/info.xml

	// lib/Provider/Email.php
	"Email verification" : "E-Mail Bestätigung",
	"Send a code to your email address" : "Sende einen Code an deine E-Mail-Adresse",

	// lib/Service/Email.php
	"Login attempt for %s" : "Anmeldeversuch für %s",
	"Your two-factor authentication code is: %s" : "Dein Zwei-Faktor Authentifizierungscode lautet: %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Gib diesen Code auf %s ein, falls du dich anmelden wolltest. Falls du das nicht warst kennt jemand deine E-Mail-Adresse oder deinen Benutzernamen – und dein Passwort!",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Du musst zuerst eine E-Mail-Adresse in 'Persönliche Informationen' hinterlegen.",

	"Could not send a verification code via email. An Admin must set this up first." : "Prüfcode konnte nicht per E-Mail versendet werden. Ein Administrator muss dies zuerst einrichten.",
	"Enable Two-Factor Email" : "Zwei-Faktor E-Mail einschalten",

	"The entered code does not match that sent to {emailAddress}." : "Der eigegebene Code unterscheidet sich von dem an {emailAddress} gesendeten.",
	"A code has been sent to {emailAddress}." : "Ein Code wurde an {emailAddress} gesendet.",
	"Verify code" : "Code bestätigen",
	"Cancel activation" : "Einschalten abbrechen",

	"Two-Factor Email is enabled. Codes are sent to {emailAddress}." : "Zwei-Faktor E-Mail ist eingeschaltet. Codes werden an {emailAddress} gesendet.",
	"Disable Two-Factor Email" : "Zwei-Faktor E-Mail ausschalten",

	// templates/error.php 
	"Error while sending the email. Please try again later or ask your administrator." : "Fehler beim Versenden der E-Mail. Bitte probiere es später nochmal oder frage deinen Administrator.",

	// templates/challenge.php
	"Two-Factor Email app icon" : "Zwei-Faktor E-Mail App-Symbol",
	"A code has been sent to your email address." : "Ein Code wurde an deine E-Mail-Adresse gesendet",
	"Authentication code" : "Authentifizierungscode",
	"Submit" : "Übermitteln",
},
"");
