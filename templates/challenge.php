<?php

?>

<form method="POST" class="email-form">
	<input type="tel" minlength="6" maxlength="10" name="challenge" required="required" autofocus autocomplete="off" autocapitalize="off" placeholder="<?php p($l->t('Authentication code')) ?>">
	<button type="submit">
		<span><?php p($l->t('Submit')); ?></span>
	</button>
	<p><?php p($l->t('Get the authentication code from the e-mail send to you.')) ?></p>
</form>
