<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException; // <-- Tambahkan ini jika belum ada

class Login extends BaseLogin
{
    /**
     * Metode ini untuk membangun form login.
     * Bagian ini sudah benar.
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autocomplete('username'),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data'); // <-- Sebaiknya tambahkan statePath
    }

    /**
     * PERBAIKAN: Tambahkan metode ini.
     *
     * Metode ini akan mengambil data dari form ('username' dan 'password')
     * dan menyiapkannya untuk proses otentikasi di backend.
     * Ini akan menggantikan perilaku default yang mencari 'email'.
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
}
