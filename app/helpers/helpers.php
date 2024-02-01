<?php

if (!function_exists('computTokenCharge')) {
	function computTokenCharge($token)
	{
		$charge = $token/20;
		return $charge;
	}
}