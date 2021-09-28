<form method="POST" class="email-2fa-form">
	<p><?php p($l->t('An access code has been sent to %s. Please insert it here:', [$_['emailAddress']])); ?></p>
	<input type="text"
		   class="challenge"
		   name="challenge"
		   required="required"
		   autofocus
		   autocomplete="off"
		   autocapitalize="off"
		   value="<?php echo isset($_['secret']) ? $_['secret'] : '' ?>"
		   placeholder="<?php p($l->t('Access code')) ?>">
	<input type="submit" class="confirm-inline icon-confirm" value="">
</form>
