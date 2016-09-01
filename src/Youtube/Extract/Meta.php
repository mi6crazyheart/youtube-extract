<?php namespace Youtube\Extract;

class Meta {

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