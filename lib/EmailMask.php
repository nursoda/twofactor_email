<?php

namespace OCA\TwoFactorEmail;

class EmailMask {

	/**
	 * convert test@example.com to ***t@example.com
	 */
	public static function maskEmail(string $email): string {
		$at = strrpos($email, "@");

		if ($at === false) {
			return $email;
		}

		$start = $at - 1;

		return str_repeat('*', $start) . substr($email, $start);
	}
}
