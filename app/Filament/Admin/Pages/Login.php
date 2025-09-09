<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
                $this->getPasswordFormComponent()->required(),
                // $this->getRememberFormComponent(),
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

    /**
     * Validasi form sebelum autentikasi
     */
    protected function beforeAuthenticate(): void
    {
        $data = $this->form->getState();

        // Validasi bahwa password tidak kosong
        if (empty($data['password'])) {
            Notification::make()
                ->title('Password diperlukan')
                ->body('Silakan masukkan password untuk login.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'password' => 'Password tidak boleh kosong.',
            ]);
        }

        // Validasi bahwa username tidak kosong
        if (empty($data['username'])) {
            Notification::make()
                ->title('Username diperlukan')
                ->body('Silakan masukkan username untuk login.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'username' => 'Username tidak boleh kosong.',
            ]);
        }
    }

    public function render(): View
    {
        return view('filament.admin.pages.login');
    }
}
