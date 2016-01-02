<?php

/**
 * The home manager controller for Organizations.
 *
 */
class OrganizationsHomeManagerController extends OrganizationsMainController {
	/* @var Organizations $Organizations */
	public $Organizations;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('organizations');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->Organizations->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->Organizations->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/fields.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.windows.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "organizations-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->Organizations->config['templatesPath'] . 'home.tpl';
	}
}