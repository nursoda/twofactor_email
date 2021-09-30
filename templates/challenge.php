<form method="POST" class="email-2fa-form">
	<p><?php p($l->t('A code has been sent to your email address.')); ?></p>
	<input type="text"
		   class="challenge"
		   name="challenge"
		   required="required"
		   autofocus
		   autocomplete="off"
		   autocapitalize="off"
		   value="<?php echo isset($_['secret']) ? $_['secret'] : '' ?>"
		   placeholder="<?php p($l->t('Enter authentication code')) ?>">
</form>
