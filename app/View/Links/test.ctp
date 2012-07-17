<pre>
<?php 
$xmlArray = array('previsions' => array('picto' => 'soleil'));
$xmlObject = Xml::fromArray($xmlArray, array('format' => 'tags')); // You can use Xml::build() too
$xmlString = $xmlObject->asXML();
 
echo h($xmlString);
?>
</pre>