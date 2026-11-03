<?php

return [
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'in' => 'El :attribute seleccionado no es válido.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string' => 'El campo :attribute no debe superar :max caracteres.',
    ],
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'numeric' => 'El campo :attribute debe ser un número.',
    'regex' => 'El formato del campo :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser un texto.',
    'unique' => 'El :attribute ya está registrado.',

    'custom' => [
        'telefono' => [
            'regex' => 'El teléfono debe tener entre 8 y 20 caracteres (números, espacios o guiones).',
        ],
    ],

    'attributes' => [
        'codigo' => 'código',
        'dias' => 'días',
        'email' => 'correo',
        'metodo' => 'método de pago',
        'nombre' => 'nombre',
        'password' => 'contraseña',
        'plan_id' => 'plan',
        'precio' => 'precio',
        'telefono' => 'teléfono',
    ],
];
