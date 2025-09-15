<?php

namespace App\Filament\Admin\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }
    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    /**
     * Overrides the authenticate method to use 'username'.
     *
     * @return \Illuminate\Http\Response|null
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $data = $this->form->getState();

            if (!Filament::auth()->attempt([
                'username' => $data['username'],
                'password' => $data['password'],
            ], $data['remember'])) {
                Notification::make()
                    ->title('Login Gagal')
                    ->body('Username atau password yang Anda masukkan salah!')
                    ->danger()
                    ->duration(5000)
                    ->send();

                throw ValidationException::withMessages([
                    'data.username' => 'Kredensial yang Anda masukkan tidak valid.',
                ]);
            }
        } catch (ValidationException $exception) {
            throw $exception;
        }

        /** @var \App\Models\User $user */
        $user = Filament::auth()->user();

        if (!method_exists($user, 'canAccessPanel') || !$user->canAccessPanel(Filament::getCurrentPanel())) {
            Filament::auth()->logout();

            Notification::make()
                ->title('Akses Ditolak')
                ->body('Maaf, Anda tidak memiliki izin untuk mengakses panel admin.')
                ->danger()
                ->persistent()
                ->send();

            return null;
        }

        Notification::make()
            ->title('Selamat Datang!')
            ->body('Berhasil masuk ke panel admin ' . $user->name)
            ->success()
            ->duration(3000)
            ->send();

        session()->regenerate();


        return app(LoginResponse::class);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
    // public function render(): View
    // {
    //     return view('filament.admin.pages.login');
    // }
}
