OC.L10N.register(
	"twofactor_email",
	{
	// ADDITIONAL strings to be localized in appinfo/info.xml

	// lib/Provider/Email.php
	"Email" : "Email",
	"Send a code to your email address" : "Code envoyé à votre adresse mail",

	// lib/Service/Email.php
	"Login attempt for %s" : "Tentative de connexion pour %s",
	"Your two-factor authentication code is: %s" : "Votre code d'authentification est %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Si vous êtes à l'origine de cette tentative de connexion, veuillez entrer ce code pour %s, si vous n'êtes pas à l'origine, une personne a connaissance de votre adresse et de votre mot de passe, nous vous conseillons de les modifier !",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Vous devez définir votre adresse mail dans 'Info personnelle' en premier.",

	"Could not send a verification code via email. An Admin must set this up first." : "Impossible d'envoyer l'email de vérification. L'administrateur doit d'abord configurer celui-ci.",
	"Enable Two-Factor Authentication via Email" : "Activer la double authentification par email",

	"The entered code does not match that sent to {emailAddress}." : "Le code que vous avez entré ne correspond pas au code fournis à l'adresse {emailAddress}.",
	"A code has been sent to {emailAddress}." : "Un code a été envoyé à {emailAddress}.",
	"Verify code" : "Code de vérification",
	"Cancel activation" : "Annuler la connexion",

	"Two-Factor Authentication via Email is enabled. Codes are sent to {emailAddress}." : "La double authentification par email a été activée. Le code a été envoyé à {emailAddress}.",
	"Disable Two-Factor Authentication via Email" : "Désactiver la double authentification par email",

	// templates/error.php 
	"Error while sending the email. Please try again later or ask your administrator." : "Erreur lors de l'envoie de l'email. Veuillez rééssayer plus tard ou veuillez contacter votre administrateur.",

	// templates/challenge.php
	"A code has been sent to your email address." : "Un code a été envoyé à votre adresse mail.",
	"Authentication code" : "Code d'authentification",
	"Submit" : "Valider",

	// templates/challenge_forFirstConfig.php
	"This verify your email for setup and enable this 2FA for your account" : "Celui ci permet de vérifier votre adresse mail pour la première connexion et la configuration du 2FA pour votre compte",
},
"");
