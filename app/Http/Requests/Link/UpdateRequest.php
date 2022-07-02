<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      "label" => ["string", "nullable", "max:255"],
      "url" => ["string", "url", "required", "max:255"],
      "link_id" => ["string", "required"],
    ];
  }
}
