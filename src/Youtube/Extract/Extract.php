<?php namespace Youtube;

class Extract {

	public function validateUrl($url)
	{
		$urlData = parse_url($url);
		if($urlData["host"] == 'www.youtube.com')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function greeting()
	{
		return "Good Morning";
	}

}