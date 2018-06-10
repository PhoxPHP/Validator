<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Validator\ValidationErrorBag
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Validator;

use Kit\Validator\Contracts\RuleContract;
use Kit\Validator\Contracts\AbstractRuleContract;
use Kit\Validator\Exceptions\BadRuleClassTypeException;

class ValidationErrorBag
{

	/**
	* @var 		$rules
	* @access 	protected
	* @static
	*/
	protected static $errors = [];

	/**
	* Adds a rule error to list of errors.
	*
	* @param 	$ruleError <String>
	* @param 	$rule <Kit\Validator\Contracts\AbstractRuleContract>
	* @access 	public
	* @return 	<void>
	*/
	public function setValidationRuleError(AbstractRuleContract $rule, String $ruleError)
	{
		if (!$rule instanceof RuleContract) {
			throw new BadRuleClassTypeException(
				sprintf(
					'%s rule class must implement %s',
					get_class($rule),
					'Kit\Validator\Contracts\RuleContract'	
				)
			);
		}

		if ($this->ruleHasErrors($rule->getLabel())) {
			ValidationErrorBag::$errors[$rule->getLabel()][] = $ruleError;
		}else{
			ValidationErrorBag::$errors[$rule->getLabel()] = [$ruleError];
		}
	}

	/**
	* Checks if a rule has errors.
	*
	* @param 	$label <String>
	* @access 	protected
	* @return 	<Boolean>
	*/
	protected function ruleHasErrors(String $label) : Bool
	{
		if (isset(ValidationErrorBag::$errors[$label]) && sizeof(ValidationErrorBag::$errors[$label]) > 0) {
			return true;
		}

		return false;
	}

	/**
	* Returns array of rules errors.
	*
	* @access 	public
	* @return 	<Array>
	* @static
	*/
	public static function getRulesErrors() : Array
	{
		return ValidationErrorBag::$errors;
	}

	/**
	* Get a rule errors.
	*
	* @param 	$label <String>
	* @access 	public
	* @return 	<Mixed>
	* @static
	*/
	public static function getRuleErrors(String $label)
	{
		return (ValidationErrorBag::ruleHasErrors($label)) ? 
		ValidationErrorBag::$errors[$label] : false;
	}

}