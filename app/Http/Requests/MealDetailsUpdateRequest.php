<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealDetailsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $recipe = $this->route('recipe');
        if (! $recipe || $recipe->user_id !== auth()->id()) {
            abort(404);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $recipe = $this->route('recipe');

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty' => ['required', 'string', Rule::in(['simple', 'medium', 'complex'])],
            'cooking_time' => ['required', 'integer', 'min:0'],
            'servings' => ['required', 'integer', 'min:1'],
            'lebensmittel' => ['array'],
            'lebensmittel.*.lebensmittel_id' => [
                'required',
                'integer',
                Rule::exists('lebensmittel_komplett', 'id'),
            ],
            'lebensmittel.*.unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id'),
            ],
            'lebensmittel.*.quantity' => ['required', 'numeric', 'min:0'],
            'cooking_steps' => ['array'],
            'cooking_steps.*.id' => [
                'nullable',
                'integer',
                Rule::exists('cooking_steps', 'id')
                    ->where('recipe_id', $recipe->id),
            ],
            'cooking_steps.*.instructions' => ['nullable', 'string'],
            'cooking_steps.*.preparation_time' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
