OC.L10N.register(
	"twofactor_email",
	
	// ADDITIONAL strings to be localized in appinfo/info.xml

	// lib/Provider/Email.php
	"Email" : "элетронной почте",
	"Send a code to your email address" : "Отправить код на ваш электронный адрес",

	// lib/Service/Email.php
	"Login attempt for %s" : "Попытка входа для %s",
	"Your two-factor authentication code is: %s" : "Ваш код двухфакторной аутентификации: %s",
	"If you tried to login, please enter that code on %s. If you did not, somebody else did and knows your your email address or username – and your password!" : "Если вы пытались войти, введите этот код в %s. Если вы этого не делали, это значит что кто-то другой попытался выполнить вход и знает ваш адрес электронной почты или имя пользователя, а также ваш пароль!",

	// src/components/GatewaySettings.vue
	"You need to set an email address in 'Personal info' first." : "Сначала вам нужно установить адрес электронной почты в разделе «Личная информация».",

	"Could not send a verification code via email. An Admin must set this up first." : "Не удалось отправить код подтверждения по электронной почте. Для начала администратор должен настроить сервис двухфакторной аутентификации.",
	"Enable Two-Factor Authentication via Email" : "Активируйте двухфакторную аутентификацию по электронной почте",

	"The entered code does not match that sent to {emailAddress}." : "Введенный код не совпадает с отправленным на {emailAddress}.",
	"A code has been sent to {emailAddress}." : "Код подтверждения был отправлен на {emailAddress}.",
	"Verify code" : "Подтвердить код",
	"Cancel activation" : "Отменить активацию",

	"Two-Factor Authentication via Email is enabled. Codes are sent to {emailAddress}." : "Активирована двухэтапная аутентификация по электронной почте. Коды подтверждения будут отправлены на {emailAddress}.",
	"Disable Two-Factor Authentication via Email" : "Отключить двухфакторную аутентификацию по электронной почте",

	// templates/error.php 
	"Error while sending the email. Please try again later or ask your administrator." : "Ошибка при отправке письма. Повторите попытку позже или обратитесь к администратору.",

	// templates/challenge.php
	"A code has been sent to your email address." : "Код был отправлен на ваш адрес электронной почты.",
	"Authentication code" : "Код аутентификации",
	"Submit" : "Подтвердить",
},
"");
