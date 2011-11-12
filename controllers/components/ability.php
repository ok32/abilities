<?php
/**
 * AbilityComponent
 * 
 * AbilityComponent
 *
 * @package default
 * @author ok32
 * @version $Id$
 * @copyright ok32
 **/

require APP . DS . 'app_ability.php';

class AbilityComponent extends Object {
	
	private $controller = null;
	
	private $onError = null;
	
	private $appAbilityClassName = 'AppAbility';

	/**
	 *
	 *
	 */
	public function initialize(&$controller, $settings = array()) {
		$this->controller = $controller;
		ClassRegistry::addObject(
			$this->appAbilityClassName,
			new $this->appAbilityClassName($controller->currentUser())
		);
	}
	
	/**
	 *
	 *
	 */
	public function check($action, $subject, $data = null) {
		return $this->getAbilityInstance()->check($action, $subject, $data);
	}
	
	/**
	 *
	 *
	 */	
	public function authorize($action, $subject, $data = null) {
		if(!$this->getAbilityInstance()->check($action, $subject, $data)) {
			if (is_callable($this->onError, true)) {
				call_user_func($this->onError);
			} else {
				throw new NotAble('Unauthorized');
			}
		}
	}
	
	/**
	 *
	 *
	 */	
	public function setErrorHandler($callable) {
		$this->onError = $callable;
	}
	
	/**
	 *
	 *
	 */
	private function getAbilityInstance() {
		return ClassRegistry::getObject('AppAbility');
	}

}