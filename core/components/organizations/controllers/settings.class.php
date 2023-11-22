<?php

/**
 * The settings manager controller for Organizations.
 *
 */
class OrganizationsSettingsManagerController extends modExtraManagerController {
	/* @var Organizations $Organizations */
	public $Organizations;


	/**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('organizations_core_path', null,
                $this->modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/';
        $this->Organizations = $this->modx->getService('organizations', 'Organizations', $path);
        parent::initialize();
    }


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('organizations');
	}

	/**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('organizations:default');
    }

	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->Organizations->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->Organizations->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/organizations.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/misc/utils.js');
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/fields.grid.js');
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/orgs.windows.js');
		//$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/users.windows.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/settings.panel.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/widgets/groups.grid.js');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/sections/settings.js');
		$this->addHtml('<script type="text/javascript">
Organizations.config = ' . json_encode($this->Organizations->config) . ';
        Organizations.config.connector_url = "' . $this->Organizations->config['connectorUrl'] . '";
		Ext.onReady(function() {
			MODx.load({ xtype: "organizations-page-settings"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		$this->content .=  '<div id="organizations-panel-home-div"></div>';
        return '';
	}
}
class OrganizationsMgrSettingsManagerController extends OrganizationsMainController {
}