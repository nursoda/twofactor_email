OC.L10N.register(
	"twofactor_email",
	{
	// ADDITIONAL strings to be localized in appinfo/info.xml

	// lib/Provider/Email.php
	"Email" : "E-Mail",
	"Send a code to your email address" : "Envie um código para seu endereço de e-mail",

	// lib/Service/Email.php
	"Login attempt for %s" : "Tentativa de login para %s",
	"Your two-factor authentication code is: %s" : "Seu código de autenticação de dois fatores é: %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Se você tentou fazer o login, por favor, digite este código em %s. Se você não tentou, alguém tentou e sabe o seu login e a sua senha!",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Você precisa definir primeiro o seu e-mail em 'Informações pessoais'",

	"Could not send a verification code via email. An Admin must set this up first." : "Não foi possível enviar um código de verificação por e-mail. As configurações iniciais ainda precisam ser realizadas pelo administrador.",
	"Enable Two-Factor Authentication via Email" : "Habilitar autenticação de dois fatores via e-mail",

	"The entered code does not match that sent to {emailAddress}." : "O código inserido não corresponde ao enviado para {emailAddress}.",
	"A code has been sent to {emailAddress}." : "Um código foi enviado para {emailAddress}.",
	"Verify code" : "Verificar o código",
	"Cancel activation" : "Cancelar ativação",

	"Two-Factor Authentication via Email is enabled. Codes are sent to {emailAddress}." : "A autenticação de dois fatores via e-mail está habilitada. Os códigos serão enviados para {emailAddress}.",
	"Disable Two-Factor Authentication via Email" : "Desabilitar a autenticação de dois fatores via e-mail",

	// templates/error.php 
	"Error while sending the email. Please try again later or ask your administrator." : "Erro ao enviar o e-mail. Por favor, tente novamente mais tarde ou entre em contato com o seu administrador",

	// templates/challenge.php
	"A code has been sent to your email address." : "Um código foi enviado para o seu e-mail.",
	"Authentication code" : "Código de autenticação",
	"Submit" : "Submeter",
},
"");
