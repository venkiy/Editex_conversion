<?php

namespace App\Http\Requests\Backend\Editex;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProcessArticleRequest.
 */
class ProcessArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('process-article');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filename' => 'required|max:191',            
        ];
    }
}
