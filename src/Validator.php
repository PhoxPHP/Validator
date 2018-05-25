<?php
/**
* @author 	Peter Taiwo
* @package 	Kit\Validator\Validator
*
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Validator;

use Kit\Validator\Config;
use Kit\Validator\ValidationErrorBag;
use Kit\Validator\Contracts\RuleContract;
use Kit\Validator\Exceptions\InvalidRuleException;

class Validator
{
	
	/**
	* @var 		$errorBag
	* @access 	protected
	*/
	protected	$errorBag;

	/**
	* Validator construct
	*
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$this->errorBag = new ValidationErrorBag();
	}

	/**
	* Creates a new validation rule.
	*
	* @param 	$label <String> | rule label
	* @param 	$value <Mixed> | value to be validated
	* @param 	$rule <String> | rule class name
	* @param 	$options <Array> | array of rule parameters
	* @access 	public
	* @return 	Object
	*/
	public function createRule(String $label, $value, String $rule, ...$options)
	{
		$rulesMapping = Config::getOption('rules_mapping');
		$rulesErrorMessages = Config::getOption('rules_error_messages');
		if (!isset($rulesMapping[$rule])) {
			throw new InvalidRuleException(sprintf('Validation rule {%s} does not exist.', $rule));
		}

		if (!is_array($value)) {
			$value = [$value];
		}

		$rule = $rulesMapping[$rule];
		$ruleObject = new $rule($label, $value, $options, $this->errorBag, $rulesErrorMessages);
		$ruleObject->validateRule();
	}

	/**
	* Checks if validation has errors.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasErrors() : Bool
	{
		if (!empty($this->getAllErrors())) {
			return true;
		}

		return false;
	}

	/**
	* Returns all rule errors.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getAllErrors()
	{
		return ValidationErrorBag::getRulesErrors();
	}

	/**
	* Returns a rule error.
	*
	* @param 	$label <String>
	* @access 	public
	*/
	public function getRuleErrors(String $label)
	{
		$errors = $this->getAllErrors();
		return $errors[$label] ?? null;
	}

	/**
	* Returns an array of first rule errors without keys.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getErrorsIndex()
	{
		$errors = [];

		if ($this->hasErrors()) {
			foreach(array_values($this->getAllErrors()) as $error) {
				$errors[] = $error[0];
			}
		}

		return $errors;
	}

	/**
	* Returns an array of first rule errors with keys.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getErrorsIndexWithKey()
	{
		$errors = [];

		if ($this->hasErrors()) {
			$keys = array_keys($this->getAllErrors());
			foreach(array_values($this->getAllErrors()) as $i => $error) {
				$errors[$keys[$i]] = $error[0];
			}
		}

		return $errors;
	}
}