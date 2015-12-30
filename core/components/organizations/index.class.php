<?php

/**
 * Class OrganizationsMainController
 */
abstract class OrganizationsMainController extends modExtraManagerController {
	/** @var Organizations $Organizations */
	public $Organizations;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('organizations_core_path', null, $this->modx->getOption('core_path') . 'components/organizations/');
		require_once $corePath . 'model/organizations/organizations.class.php';

		$this->Organizations = new Organizations($this->modx);
		//$this->addCss($this->Organizations->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->Organizations->config['jsUrl'] . 'mgr/organizations.js');
		$this->addHtml('
		<script type="text/javascript">
			Organizations.config = ' . $this->modx->toJSON($this->Organizations->config) . ';
			Organizations.config.connector_url = "' . $this->Organizations->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('organizations:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends OrganizationsMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}