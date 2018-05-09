<?php
/**
 * Dump data.
 * If wfHelp.isLocalhost().
 * If dump=true in theme settings.yml.
 * If querystring _time is not set to avoid not dump data in ajax request.
 * Querystring _time could render dump if dump_ajax=true in theme settings.yml.
 */
class PluginWfDump{
  /**
   * Event to dump data.
   * To run at end of a document one could use the sys_close event.
   */
  public function event_dump(){
    if(!wfHelp::isLocalhost() || !wfArray::get($GLOBALS, 'sys/settings/dump')){
      return null;
    }
    if(wfRequest::get('_time') && !wfArray::get($GLOBALS, 'sys/settings/dump_ajax')){
      return null;
    }
    $element = array();
    if($_SESSION){
      $element[] = wfDocument::createHtmlElement('pre', '<b>$_SESSION</b><br>'.wfHelp::getYmlDump($_SESSION));
    }
    if($_GET){
      $element[] = wfDocument::createHtmlElement('pre', '<b>$_GET</b><br>'.wfHelp::getYmlDump($_GET));
    }
    if($_POST){
      $element[] = wfDocument::createHtmlElement('pre', '<b>$_POST</b><br>'.wfHelp::getYmlDump($_POST));
    }
    $element[] = wfDocument::createHtmlElement('pre', '<b>$GLOBALS/sys</b><br>'.wfHelp::getYmlDump($GLOBALS['sys']));
    $element[] = wfDocument::createHtmlElement('pre', '<b>$_SERVER</b><br>'.wfHelp::getYmlDump($_SERVER));
    wfDocument::renderElement(array(wfDocument::createHtmlElement('div', array(wfDocument::createHtmlElement('div', array(wfDocument::createHtmlElement('div', $element, array('class' => 'col-md-12'))), array('class' => 'row'))), array('class' => 'container-fluid'))));
  }
}
