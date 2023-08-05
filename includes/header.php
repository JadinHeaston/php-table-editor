<?PHP
//Create version hashes based on last modified time.
$versionedFiles = array(
	'js/scripts.js' => '',
	'css/styles.css' => '',
);

foreach ($versionedFiles as $fileName => $hash)
{
	$versionedFiles[$fileName] = substr(md5(filemtime($fileName)), 0, 6);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Table Editor</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="icon" type="image/svg+xml" href="favicon.svg">
	<link rel="preload" as="style" href="css/styles.css?v=<?PHP echo $versionedFiles['css/styles.css']; ?>">
	<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
	<script src="js/scripts.js?v=<?PHP echo $versionedFiles['js/scripts.js']; ?>" type="module"></script>
</head>

<body>