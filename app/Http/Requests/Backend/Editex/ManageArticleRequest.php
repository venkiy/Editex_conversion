<?php

namespace App\Http\Requests\Backend\Editex;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManageArticleRequest.
 */
class ManageArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-process-management');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
