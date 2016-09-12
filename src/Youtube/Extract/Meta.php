<?php namespace Youtube\Extract;

class Meta {

	private $client;
	private $videoUrl;
	private $googleApiKey;
	private $videoInfo;
	private $errorInfo;


	function __construct($videoUrl, $googleApiKey) {
		$this->client = new \GuzzleHttp\Client();
		$this->videoUrl = $videoUrl;
		$this->googleApiKey = $googleApiKey;

		// Check given url is a valid youtube url or not
		if(!$this->validateUrl($this->videoUrl)){
			$this->errorInfo[] = "Invalid youtube url";
		} elseif(!$this->videoInfo = $this->fetchYoutubeVideoInfo($this->videoUrl, $this->googleApiKey)){
				$this->errorInfo[] = "YouTube video ID not found. Please double-check your URL.";
			} elseif(!$this->videoInfo->pageInfo->totalResults) {
				$this->errorInfo[] = "No video details found";
			}
		}


	public function fetchErrorInfo()
	{
		return $this->errorInfo;
	}


	public function validateUrl($url)
	{
		$urlData = parse_url($url);

		if($urlData["host"] == 'www.youtube.com')
			return true;
		else
			return false;
	}


	private function getYoutubeVideoId($youtubeUrl)
	{
		$youtubeVidIdLen = 11; // This is the length of YouTube's video IDs

		// The ID string starts after "v=", which is usually right after
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($youtubeUrl, "?v=");

		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
		// bases covered), it will be after an "&":
		if($idStarts === FALSE)
			$idStarts = strpos($youtubeUrl, "&v=");

		// If still FALSE, URL doesn't have a vid ID
		if($idStarts === FALSE){
			//die("YouTube video ID not found. Please double-check your URL.");
			return false;
		} else {
			// Offset the start location to match the beginning of the ID string
			$idStarts +=3;

			// Get the ID string and return it
			$youtubeVidId = substr($youtubeUrl, $idStarts, $youtubeVidIdLen);

			return $youtubeVidId;
		}
	}


	private function fetchYoutubeVideoInfo($videoUrl, $googleApiKey)
	{
		// Fetch Youtube video Id
		$youtubeId = $this->getYoutubeVideoId($videoUrl);

		if(!$youtubeId)
			return false;

		// Construct URL for fetching data from youtube api
		$youtubeApiUrl = 'https://www.googleapis.com/youtube/v3/videos?id='.$youtubeId.'&key='.$googleApiKey.'&part=snippet,contentDetails,statistics,status';

		// Fetch youtube video info
		$apiResponse = $this->client->request('GET', $youtubeApiUrl);

		return json_decode($apiResponse->getBody());
	}


	public function fetchThumbnails($type=false)
	{
		if(count($this->errorInfo))
			return false;
		elseif($type)
			return $this->videoInfo->items[0]->snippet->thumbnails->$type;
		else
			return $this->videoInfo->items[0]->snippet->thumbnails;
	}

	public function fetchTitle()
	{
		if(count($this->errorInfo))
			return false;
		else
			return $this->videoInfo->items[0]->snippet->title;
	}


	public function fetchDescription()
	{
		if(count($this->errorInfo))
			return false;
		else
			return $this->videoInfo->items[0]->snippet->description;
	}


	public function fetchStatistics()
	{
		if(count($this->errorInfo))
			return false;
		else
			return $this->videoInfo->items[0]->statistics;
	}

}