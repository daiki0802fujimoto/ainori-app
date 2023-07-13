<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'post.user_id' => 'required|integer|',
            'post.origin' => 'required|string|max:40',
            'post.destination' => 'required|string|max:40',
            'post.people' => 'required|integer|max:3',
            'post.time_zone' => 'required|date',
            'post.comment' => 'required|string|max:200',
        ];
    }
}
