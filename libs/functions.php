<?php

global $APP, $CONTEXT;

/*================================ CONTEXT FUNCTIONS =================================*/
function context() {
	return get_context();
}
function get_context() {
	global $CONTEXT;
	if (! $CONTEXT) {
		$CONTEXT = new Context();
	}
	return $CONTEXT;
}
function get_request() {
	return context()->getRequest();
}
function get_response() {
	return context()->getResponse();
}
function get_attribute($name) {
	return context()->getAttribute($name);
}

function set_attribute($name, $value) {
	return context()->setAttribute($name, $value);
}

function get_parameter($name) {
	return context()->getParameter($name);
}

function set_parameter($name, $value) {
	return context()->setParameter($name, $value);
}

function get_session($name) {
	return context()->getSessionAttribute($name);
}

function set_session($name, $value) {
	return context()->setSessionAttribute($name, $value);
}

/*================================ COMPONENT FUNCTIONS =================================*/
function import($file) {
	include_once ROOT . $file;
}
function get_component($name, $paths = null) {
	return ComponentLoader::getComponent($name, $paths);
}

/*================================ XML FUNCTIONS =================================*/
class SimpleXMLExtended extends SimpleXMLElement {
	public function addCData($cdata_text) {
		$node = dom_import_simplexml($this);
		$document = $node->ownerDocument;
		$node->appendChild($document->createCDATASection($cdata_text));
	}
}

function load_xml($file) {
	if (is_readable($file)) {
		return simplexml_load_file($file, 'SimpleXMLExtended', LIBXML_NOCDATA);
	}
	return FALSE;
}

?>