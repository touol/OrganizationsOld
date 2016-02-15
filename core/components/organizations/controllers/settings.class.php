<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class ControllersSettingsManagerController extends OrganizationsMainController {
	public static function getDefaultController() {
		return 'settings';
	}
}
class OrganizationsSettingsManagerController extends OrganizationsMainController {
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
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/fields.grid.js');
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.windows.js');
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/users.windows.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/settings.panel.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/groups.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/sections/settings.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "organizations-page-settings"});
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
// MODX 2.3
class ControllersMgrSettingsManagerController extends ControllersSettingsManagerController {
	public static function getDefaultController() {
		return 'settings';
	}
}
class OrganizationsMgrSettingsManagerController extends OrganizationsMainController {
}