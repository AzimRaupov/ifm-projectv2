<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'old'      => ['required', 'integer', 'min:3', 'max:120'],
            'role'     => ['required', 'in:student,teacher'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'Введите ваше имя.',
            'name.string'        => 'Имя должно быть строкой.',
            'name.max'           => 'Имя не должно превышать 255 символов.',

            'email.required'     => 'Введите адрес электронной почты.',
            'email.string'       => 'Email должен быть строкой.',
            'email.email'        => 'Введите корректный адрес электронной почты.',
            'email.max'          => 'Email не должен превышать 255 символов.',
            'email.unique'       => 'Этот email уже зарегистрирован.',

            'old.required'       => 'Укажите ваш возраст.',
            'old.integer'        => 'Возраст должен быть числом.',
            'old.min'            => 'Минимальный возраст — 3 лет.',
            'old.max'            => 'Максимальный возраст — 120 лет.',

            'role.required'      => 'Выберите вашу роль.',
            'role.in'            => 'Роль должна быть либо "Ученик", либо "Учитель".',

            'password.required'  => 'Введите пароль.',
            'password.min'       => 'Пароль должен содержать минимум 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',

        ];
    }
}
