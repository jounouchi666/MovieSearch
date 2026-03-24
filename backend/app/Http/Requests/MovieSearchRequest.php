<?php

namespace App\Http\Requests;

use App\Application\Query\MovieSearchQuery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MovieSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $allowedMaxYear = date('Y') + 5;

        return [
            'title'         => ['required', 'string', 'max:255'],
            'include_adult' => ['nullable', 'boolean'],
            'year'          => ['nullable', 'numeric', 'digits:4', 'min:1900', 'max:'. $allowedMaxYear],
            'page'          => ['nullable', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '必須項目です。',
            'title.string'   => '入力値が不正です。',
            'title.max'      => ':max文字以内で入力してください。',
            
            'include_adult'  => '入力値が不正です。',

            'year.numeric'   => '入力値が不正です。',
            'year.digits'    => '西暦4桁で入力してください。',
            'year.min'       => ':min年以降の年を入力してください。',
            'year.max'       => ':max年までの年を入力してください。'
        ];
    }

    public function buildQuery(): MovieSearchQuery
    {
        return new MovieSearchQuery(
            $this->string('title'),
            $this->boolean('include_adult'),
            $this->integer('year') ?: null,
            $this->integer('page', 1)
        );
    }
}
