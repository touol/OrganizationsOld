<?php
$formFields = $hook->getValues();
if($formFields['lico'] != "urlico") return true;
if(!empty($formFields['org']['shortname'])){
    return true;
}
$errorMsg = '<span class="error">Это поле требуется.</span>';
$hook->addError('org_shortname',$errorMsg);
return false;