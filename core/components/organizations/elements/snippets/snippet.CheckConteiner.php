<?php
$formFields = $hook->getValues();
if(!empty($formFields['org']['shortname'])){
    return true;
}
$errorMsg = '<span class="error">Это поле требуется.</span>';
$hook->addError('org[shortname]',$errorMsg);
return false;