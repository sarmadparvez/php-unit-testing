<?php

/**
* A trait to get common utilities
*/
trait RTGSyncHelper
{

	/**
	* @codeCoverageIgnore
	*/
	protected function getSugarConfig()
	{
		return SugarConfig::getInstance();
	}

	/**
	* @codeCoverageIgnore
	*/
	protected function getSugarQuery()
	{
		return new SugarQuery();
	}
}
