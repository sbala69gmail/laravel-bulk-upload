<?php
/**
 * BaseValidationRequest file
 *
 * PHP Version 7.2
 *
 * @category Eloquent
 * @author   Balasubramani <balasubramani@engagefresh.com>
 * @version  Release: v 1.0 2020/06/06 00:00:00 base model
 * @version  SVN: $Id$
 */
namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * BaseValidationRequest class
 *
 * This is base validation used to all the validation file.
 *
 * @category Eloquent
 * @author   Balasubramani <balasubramani@engagefresh.com>
 * @version  Release: 1.0.0
 */
abstract class BaseValidationRequest
{
    abstract public function rules();

    /**
     * validate
     *
     * This used to validate the user record.
     *
     * @param  mixed $data
     * @param  mixed $rules
     * @return array
     */
    public function validate($data, $rules)
    {
        $messages = [];
        if (isset($this->messages)) {
            $messages = $this->messages;
        }
        $validator = Validator::make($data, $rules, $messages);

        if (isset($this->attributes)) {
            $validator->setAttributeNames($this->attributes);
        }

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    /**
     * checkValidation
     *
     * Check the validation data after the validated data to return to previous function.
     *
     * @param  mixed $data
     * @param  mixed $merge
     * @param  mixed $extraParams
     * @return void
     */
    public function checkValidation(array $data, array $merge, $extraParams = [])
    {
        $rules = Arr::only($this->rules(), $merge);
        $validated = $this->validate($data, $rules);
        $array = array_merge($validated, array_intersect_key($data, array_flip($extraParams)));
        if (isset($this->date_formats)) {
            foreach ($this->date_formats as $field) {
                if (isset($array[$field])) {
                    $array[$field] = Carbon::parse($array[$field])->setTimezone(config('app.timezone'));
                }
            }
        }
        return $array;
    }
}
