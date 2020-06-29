<?php
require __DIR__. '/PuppyPoop.php';
require __DIR__ . '/config.php';



//ini_set('display_errors', 'on');


$width = filter_input(INPUT_GET, 'width');
$height = filter_input(INPUT_GET, 'height');

$offsetLeft = filter_input(INPUT_GET, 'offsetLeft');
$offsetTop = filter_input(INPUT_GET, 'offsetTop');
$id = filter_input(INPUT_GET, 'id');
$toImage = filter_input(INPUT_GET, 'toImage');
$toGallery = filter_input(INPUT_GET, 'gallery');
$autofocus = filter_input(INPUT_GET, 'autofocus');


$perPage = 100;
$data = json_decode(
    file_get_contents($apiURL . '/media?per_page=' . $perPage),
    true
);
$data = array_reverse($data);



if ($toGallery) {
    foreach ($data as $index => $node) {
        $imageData = $node['media_details']['sizes']['full'];
        $imageURL = $imageData['source_url'];
        $imageMime = $imageData['mime_type'];

        $focusPoint = explode(
            '-',
            trim(preg_replace('`<p>(.*?)</p>`s', '$1', $node['caption']['rendered']))
        );

        $application = new PuppyPoop(__DIR__ . '/source', __DIR__ . '/thumbnail');
        $source = $application->getImage($imageURL);
        $output = $application->crop($source, $width, $height, $focusPoint[0], $focusPoint[1], (int) $offsetLeft, (int) $offsetTop, $autofocus);

        echo '<img src="./thumbnail/' . basename($output) . '"/>';
    }
} else {
    if ($id === null) {
        $id = rand(0, count($data) - 1);
    } else {
        $id = $id % count($data);
    }

    $node = $data[$id];
    $imageData = $node['media_details']['sizes']['full'];
    $imageURL = $imageData['source_url'];
    $imageMime = $imageData['mime_type'];

    $focusPoint = explode(
        '-',
        trim(preg_replace('`<p>(.*?)</p>`s', '$1', $node['caption']['rendered']))
    );

    $application = new PuppyPoop(__DIR__ . '/source', __DIR__ . '/thumbnail');
    $source = $application->getImage($imageURL);
    $output = $application->crop($source, $width, $height, $focusPoint[0], $focusPoint[1], (int) $offsetLeft, (int) $offsetTop, $autofocus);

    if (!$toImage) {
        $imageData = getimagesize($output);
        $duration = 3600 * 60 * 24;
        $ts = gmdate('D, d M Y H:i:s', time() + $duration) . ' GMT';
        header("Expires: $ts");
        header('Pragma: cache');
        header("Cache-Control: max-age=$duration");
        header('Content-type: ' . $imageData['mime']);
        echo file_get_contents(($output));
    } else {
        echo '<img src="thumbnail/' . basename($output) . '"/>';
    }
}
