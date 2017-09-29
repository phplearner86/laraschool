<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumSpaces;
use App\Rules\AlphaNumSpacesPunctuation;
use App\Services\Utilities\Year;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $years = implode(',', array_keys(Year::all()));

        $subject_ids = $this->user->teacher->subjects->unique()->pluck('id')->toArray();
        $subject_ids = implode(',', $subject_ids);

        $titles = $this->user->teacher->lessons->pluck('title');

        return [
            'subject_id' => [
                'required',
                'in:' . $subject_ids,
            ],
            'title' => [
                'required',
                'max:80',
                Rule::unique('lessons')->where(function($query){
                    $query->where('teacher_id', $this->user->teacher->id);
                }),
                new AlphaNumSpaces,
            ],
            'topic' => [
                'required',
                'max:150',
                new AlphaNumSpacesPunctuation,
            ],
            'year' => 'required|in:' . $years,
            'goals' => [
                'required',
                'max:300'
            ]
        ];
    }
}
