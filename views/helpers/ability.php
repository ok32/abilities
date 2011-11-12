<?php
/**
 * AbilityHelper
 * 
 * AbilityHelper
 *
 * @package default
 * @author ok32
 * @version $Id$
 * @copyright ok32
 **/

class AbilityHelper extends AppHelper {

	public function check($action, $subject, $data = null) {
		return $this->getAbilityInstance()->check($action, $subject, $data);
	}

	private function getAbilityInstance() {
		return ClassRegistry::getObject('AppAbility');
	}
}