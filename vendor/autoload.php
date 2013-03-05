<?php

	spl_autoload_register(function($class)
	{
		return include dirname(__FILE__) . '/' . strtolower(str_replace('\\', '/', $class)) . '.php';
	});