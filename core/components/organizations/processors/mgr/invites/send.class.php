<?php

/**
 * Remove an Invites
 */
class OrganizationsOrgInviteSendProcessor extends modProcessor {
	public $objectType = 'OrgsInvites';
	public $classKey = 'OrgsInvites';
	public $languageTopics = array('organizations');
	public $permission = 'save';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('organizations_item_err_ns'));
		}
		if (!$Orgs = $this->modx->getService('organizations', 'Organizations',$this->modx->getOption('organizations_core_path', null, $this->modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', array())) {
			return $this->failure($this->modx->lexicon($this->objectType.'_Could not load Organizations class!'));
		}
		$invite_email_tpl = $this->modx->getOption('invite_email_tpl', null, 'invite_email_tpl');
		$invite_email_subject = $this->modx->getOption('invite_email_subject', null, 'Приглашение на сайт!');
		foreach ($ids as $id) {
			/** @var OrganizationsOrg $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('organizations_item_err_nf'));
			}

			$data = $object->toArray();
			$body = $this->modx->getChunk($invite_email_tpl, $data);
			$object->email_sended = $Orgs->sendEmail($data['email'], $invite_email_subject, $body);
			if (!$object->email_sended) {
				return $this->failure($this->modx->lexicon($this->objectType.'_err_send'));
			}
			if (!$object->save()) {
				$this->modx->error->checkValidation($this->object);
				return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
			}
		}

		return $this->success();
	}

}

return 'OrganizationsOrgInviteSendProcessor';