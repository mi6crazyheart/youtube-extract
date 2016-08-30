<?php namespace mi6crazyheart\Youtube;

class Youtube {

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

}