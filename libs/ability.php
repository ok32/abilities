<?php

/**
 *
 *
 */

require 'rule.php';

class Ability {
	
	protected $user;
	
	private $rules = array();
	
	public function __construct($user) {
		$this->user = $user;
	}
	
	public function allow($action, $subject, $conditions = null, $callableConditions = false) {
		$this->rules[] = new Rule(true, $action, $subject, $conditions, $callableConditions);
	}
	
	public function deny($action, $subject, $conditions = null, $callableConditions = false) {
		$this->rules[] = new Rule(false, $action, $subject, $conditions, $callableConditions);
	}
	
	public function check($action, $subject, $data = null) {
		$matchedRule = null;
		foreach(array_reverse($this->rules) as $rule) {
			if ($rule->matches($action, $subject, $data)) {
				$matchedRule = $rule;
				break;
			}
		}
		if ($matchedRule) {
			return $matchedRule->baseBehavior();
		}
		return false;
	}

}

class NotAble extends Exception {
	public function __construct() {
        parent::__construct('You are not able to do that');
    }
}