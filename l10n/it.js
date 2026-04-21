OC.L10N.register(
	"twofactor_email",
	{
	// ADDITIONAL strings to be localized in appinfo/info.xml

	// lib/Provider/Email.php
	"Email" : "Email",
	"Send a code to your email address" : "Invia un codice al tuo indirizzo email",

	// lib/Service/Email.php
	"Login attempt for %s" : "Tentativo di accesso per %s",
	"Your two-factor authentication code is: %s" : "Il tuo codice di autenticazione a due fattori è: %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Se hai effettuato tu questo tentativo di accesso, inserisci il codice su %s. In caso contrario, qualcun altro lo ha fatto e conosce il tuo indirizzo email o nome utente – e la tua password!",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Devi prima impostare un indirizzo email in 'Informazioni personali'.",

	"Could not send a verification code via email. An Admin must set this up first." : "Impossibile inviare il codice di verifica via email. Un amministratore deve prima configurare questa funzione.",
	"Enable Two-Factor Authentication via Email" : "Abilita l'autenticazione a due fattori via email",

	"The entered code does not match that sent to {emailAddress}." : "Il codice inserito non corrisponde a quello inviato a {emailAddress}.",
	"A code has been sent to {emailAddress}." : "Un codice è stato inviato a {emailAddress}.",
	"Verify code" : "Verifica codice",
	"Cancel activation" : "Annulla attivazione",

	"Two-Factor Authentication via Email is enabled. Codes are sent to {emailAddress}." : "L'autenticazione a due fattori via email è abilitata. I codici vengono inviati a {emailAddress}.",
	"Disable Two-Factor Authentication via Email" : "Disabilita l'autenticazione a due fattori via email",

	// templates/error.php
	"Error while sending the email. Please try again later or ask your administrator." : "Errore durante l'invio dell'email. Riprova più tardi o contatta il tuo amministratore.",

	// templates/challenge.php
	"A code has been sent to your email address." : "Un codice è stato inviato al tuo indirizzo email.",
	"Authentication code" : "Codice di autenticazione",
	"Submit" : "Invia",
},
"");
