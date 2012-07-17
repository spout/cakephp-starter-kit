<?php
header("Content-Type: application/vnd.google-earth.kml+xml");
$filename = 'markers.kml';
header("Content-Disposition: attachment; filename=$filename");
echo $this->fetch('content');
?>