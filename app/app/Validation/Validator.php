<?php

namespace app\Validation;

use Violin\Violin;

use app\User\User;
use app\Helpers\Hash;

class Validator extends Violin
{
    protected $user;

    protected $hash;

    protected $auth;

    public function __construct(User $user, Hash $hash, $auth = null)
    {
        $this->user = $user;

        $this->hash = $hash;

        $this->auth = $auth;


        $this->addFieldMessages([
            'email' => [
                'uniqueEmail' => 'That email is already in use.'
            ],

            'username' => [
                'uniqueUsername' => 'That username is already in use.'
            ],
            'not_null' => [
                'not_null' => 'That variable is null.'
            ]
        ]);

        $this->addRuleMessages([
            'matchesCurrentPassword'=> 'That does not match your current password.',
            'alnumDashSpc' => '{field} must be alphanumeric with dashes underscores, and spaces permitted.'
        ]);
    }

    public function validate_uniqueEmail($value, $input, $args)
    {
        $user = $this->user->where('email', $value);

        if ($this->auth && $this->auth->email === $value) {
            return true;
        }

        return ! (bool) $user->count();
    }

    public function validate_uniqueUsername($value, $input, $args)
    {
        return ! (bool) $this->user->where('username', $value)->count();
    }

    public function validate_matchesCurrentPassword($value, $input, $args)
    {
        if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
            return true;
        }

        return false;
    }
    
    public function validate_not_null($value, $input, $args)
    {
        return ! (bool) is_null($value);
    }

    public function validate_alnumDashSpc($value, $input, $args)
    {
        return (bool) preg_match('/^[\s\pL\pM\pN_-]+$/u', $value);
    }

    public function constructArray($success = true, $errors = null, $url, $json = true)
    {
        if (!is_null($errors)) {
            $keys = $this->errors()->keys();
            $messages = $this->errors()->all();
            $errorArray = [];
            $v = 0;

            foreach ($messages as $error) {
                $errorArray[] = [
                    "item" => $keys[$v],
                    "message" => $messages[$v],
                ];

                $v++;
            };
        }

        $array = [
                "success" => $success,
                "errors" => $errorArray ? $errorArray : null,
                "url" => $url
        ];

        if ($json) {
            return json_encode($array);
        }

        return $array;
    }
}
