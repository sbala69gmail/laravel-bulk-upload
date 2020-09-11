<?php
namespace App\Http\Requests;

use App\Http\Requests\BaseValidationRequest;
use Illuminate\Support\Facades\Hash;

class UserValidator extends BaseValidationRequest
{
    public $fields = [];
    public $quickAdd = [];
    public $fullAdd = [];
    public $messages = [];
    public $rules = [];

    public function __construct()
    {
        $this->rules = [
            'users' => ['required', 'array'],
            'users.*' => ['required', 'array'],
            'users.*.first_name' => ['required', 'string', 'min:2', 'max:180'],
            'users.*.last_name' => ['required', 'string', 'min:2', 'max:180'],
            'users.*.email' => ['required', 'email', 'min:2', 'max:180', 'unique:users,email', 'distinct'],
            'users.*.mobile_no' => ['required', ],
            'users.*.address' => ['nullable', 'string', 'min:0', 'max:500'],

            'upload' => ['required', 'file', 'mimes:xlsx', 'max:4096'],
        ];
    }

    public function rules()
    {
        return $this->rules;
    }

    public function upload(array $data)
    {
        $checkField = [
            'upload',
        ];
        return $this->checkValidation($data, $checkField);
    }

    public function store(array $data)
    {
        $checkField = [
            'users',
            'users.*',
            'users.*.first_name',
            'users.*.last_name',
            'users.*.email',
            'users.*.mobile_no',
            'users.*.address',
        ];
        return $this->checkValidation($data, $checkField);
    }
}
