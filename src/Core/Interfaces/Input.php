<?php namespace App\Core\Interfaces;

class Input extends \Statical\BaseProxy
{
	// TODO: Arraner méthodes ci-dessous pour shortcut Input::get('param', 'default'), Input::post et Input::query
	// Utiliser Request::...
	public static function file($name)
	{
		return isset($_FILES[$name]) && $_FILES[$name]['size'] ? $_FILES[$name] : null;
	}

	/**
	* Fetch request parameter value from body or query string (in that order).
	*
	* Note: This method is not part of the PSR-7 standard.
	*
	* @param  string $key The parameter key.
	* @param  string $default The default value.
	*
	* @return mixed The parameter value.
	*/
	public function getParam($key, $default = null)
	{
		$postParams = $this->getParsedBody();
		$getParams = $this->getQueryParams();
		$result = $default;
		if (is_array($postParams) && isset($postParams[$key])) {
			$result = $postParams[$key];
		} elseif (is_object($postParams) && property_exists($postParams, $key)) {
			$result = $postParams->$key;
		} elseif (isset($getParams[$key])) {
			$result = $getParams[$key];
		}
		return $result;
	}
	/**
	* Fetch parameter value from request body.
	*
	* Note: This method is not part of the PSR-7 standard.
	*
	* @param      $key
	* @param null $default
	*
	* @return null
	*/
	public function getParsedBodyParam($key, $default = null)
	{
		$postParams = $this->getParsedBody();
		$result = $default;
		if (is_array($postParams) && isset($postParams[$key])) {
			$result = $postParams[$key];
		} elseif (is_object($postParams) && property_exists($postParams, $key)) {
			$result = $postParams->$key;
		}
		return $result;
	}
	/**
	* Fetch parameter value from query string.
	*
	* Note: This method is not part of the PSR-7 standard.
	*
	* @param      $key
	* @param null $default
	*
	* @return null
	*/
	public function getQueryParam($key, $default = null)
	{
		$getParams = $this->getQueryParams();
		$result = $default;
		if (isset($getParams[$key])) {
			$result = $getParams[$key];
		}
		return $result;
	}
}
