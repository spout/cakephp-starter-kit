<?php
$this->set('title_for_layout', __('Datatable'));

$this->Html->css('http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css', null, array('inline' => false));
$this->Html->script('http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js', array('inline' => false));

echo $this->DataTable->render($modelClass, array(), array('sAjaxSource' => $this->Html->url(array('?' => array('model' => $modelClass)))));