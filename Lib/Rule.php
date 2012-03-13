<?php
/**
* 
*/
class Rule {

	private $action = null;
	private $subject = null;
	private $conditions = null;
	private $callableConditions = false;
	private $baseBehavior = false;
	
	private $crudActions = array('create', 'read', 'update', 'delete');
	
	public function __construct($baseBehavior, $action, $subject, $conditions = null, $callableConditions = false) {
		$this->action = $action;
		$this->subject = $subject;
		$this->conditions = $conditions;
		$this->callableConditions = $callableConditions;
		$this->baseBehavior = $baseBehavior;
	}
	
	public function matches($action, $subject, $data = null) {
		if ($this->matchesAction($action)) {
			if ($subject === true) {
				#
				return true;
			} else if ($this->matchesSubject($subject)) {
				if (empty($data)) {
					# 
					return true;
				}
				if ($this->callableConditions) {
					# run callback
					return call_user_func($this->conditions, $data);
				} else {
					# just match with Set
					return Set::matches($this->conditions, $data);
				}
			}			
			return false;
		}
	}
	
	public function baseBehavior() {
		return $this->baseBehavior;
	}
	
	private function matchesAction($action) {
		return (($action === $this->action) || ($this->action == 'manage' && in_array($action, $this->crudActions)));
	}
	
	private function matchesSubject($subject) {
		return ($subject === $this->subject || $this->subject == 'all');
	}
	
}
