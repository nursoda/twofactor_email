<p><?php p($l->t('A code has been sent to your email address.')) ?></p>
<form method="POST" class="twofactor-email-form">
	<input type="tel" minlength="6" maxlength="6" name="challenge" required="required" autofocus autocomplete="one-time-code" autocapitalize="off" placeholder="<?php p($l->t('Authentication code')) ?>">
	<button class="primary two-factor-submit" type="submit">
		<?php p($l->t('Submit')); ?>
	</button>
</form>
