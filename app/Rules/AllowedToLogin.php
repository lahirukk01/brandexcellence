<?php

namespace App\Rules;

use App\Auditor;
use App\Judge;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class AllowedToLogin implements Rule
{

    public $loginType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($loginType)
    {
        $this->loginType = $loginType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch ($this->loginType) {
            case 'judge':
                $judge = Judge::whereEmail($value)->first();
                if($judge != null && $judge->allowed == true) {
                    return true;
                }
                break;
            case 'auditor':
                $auditor = Auditor::whereEmail($value)->first();
                if($auditor != null && $auditor->allowed == true) {
                    return true;
                }
                break;
            case 'client':
                $client = User::whereEmail($value)->first();
                if($client != null && $client->allowed == true) {
                    return true;
                }
                break;
            default:
                die('Invalid login type found');
                break;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your credentials are wrong or you are not allowed to login.';
    }
}
