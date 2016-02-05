<?php

namespace app\Validation;

class Violin extends \Violin\Violin
{
    protected $user;

    protected $hash;

    protected $auth;

    public function __construct(\app\User\User $user, \app\Hash\Hash $hash, $auth = null)
    {
        $this->user = $user;

        $this->hash = $hash;

        $this->auth = $auth;

        $this->addRuleMessages([
            "MatchesCurrentPassword"=> "That does not match your current password.",
            "UniqueEmail" => "That email is already in use.",
            "UniqueUsername" => "That username is already in use.",
            "Not_null" => "That variable is null.",
            "Username" => "That username currently does\'t exist.",
        ]);
    }

    protected function getRuleToCall($rule)
    {
        if (isset($this->customRules[$rule])) {
            return $this->customRules[$rule];
        }

        if (method_exists($this, 'validate' . $rule)) {
            return [$this, 'validate' . $rule];
        }

        if (isset($this->usedRules[$rule])) {
            return [$this->usedRules[$rule], 'run'];
        }

        $ruleClass = 'Violin\\Rules\\' . ucfirst($rule) . 'Rule';
        $ruleObject = new $ruleClass();

        $this->usedRules[$rule] = $ruleObject;

        return [$ruleObject, 'run'];
    }

    public function validateUniqueEmail($value, $input, $args)
    {
        $user = $this->user->where("email", $value);

        if ($this->auth && $this->auth->email === $value) {
            return true;
        }

        return ! (bool) $user->count();
    }

    public function validateUniqueUsername($value, $input, $args)
    {
        return ! (bool) $this->user->where("username", $value)->count();
    }

    public function validateMatchesCurrentPassword($value, $input, $args)
    {
        if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
            return true;
        }

        return false;
    }

    public function validateNot_null($value, $input, $args)
    {
        return ! (bool) is_null($value);
    }
    
    public function validateUsername($value, $input, $args)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return (bool) preg_match('/^[\pL\pM\pN_-]+$/u', $value);
        }
    }
}
