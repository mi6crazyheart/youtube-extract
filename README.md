# youtube-extract

This is a simple wrapper class which will help you to find out youtube video meta info from youtube video URL. Internally it uses youtube's YouTube Data API. It requires Google API key to connect with youtube server & extract data. For more info Ref- https://developers.google.com/youtube/v3/getting-started#before-you-start

### Meta info supported
- video thumbnails
- video titles
- video description
- video statistics

### Installation
Through [Composer](https://getcomposer.org/).

```composer require mi6crazyheart/youtube-extract```

After installing, you need to require Composer's autoloader.

```require __DIR__ . '/vendor/autoload.php';```

### Getting Started

This wrapper has 5 methods.
- fetchErrorInfo() : To get all error details.
- fetchThumbnails() : Extract all video thumbnails information.
- fetchTitle() : Fetch video title.
- fetchDescription() : Fetch video description.
- fetchStatistics() : Fetch video statistics like- view count, like count, dis like count, favorite count, comment count.


### Example

```
<?php
require __DIR__ . '/vendor/autoload.php';

$videoUrl = "https://www.youtube.com/watch?v=K5WW7JOBSjg";
$googleApiKey = "USE-YOUR-Google-API-KEY";

$Meta = new Youtube\Extract\Meta($videoUrl, $googleApiKey);

if(count($Meta->fetchErrorInfo())){
	echo '<pre>';
	print_r($Meta->fetchErrorInfo());
	echo '</pre>';
} else {
	echo "<br><br>Video thumbnails";
	echo '<pre>';
		print_r($Meta->fetchThumbnails('default'));
	echo '</pre>';

	echo "<br><br>Video title : ".$Meta->fetchTitle();
	echo "<br><br>Video description : ".$Meta->fetchDescription();

	echo "<br><br>Video statistics";
	echo '<pre>';
		print_r($Meta->fetchStatistics());
	echo '</pre>';
}
```
