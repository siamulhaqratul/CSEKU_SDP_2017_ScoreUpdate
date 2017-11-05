<?php

class Validation
{
	private $error = array();

	public function check($parameter = array())
	{
		foreach ($parameter as $value) {
			if (empty($value)) {
				$this->error[] = 'error';
			}
		}
		if (empty($this->error))
		{
			return true;
		}
		return false;
	}
}

?>