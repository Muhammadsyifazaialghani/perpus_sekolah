<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;

use App\Models\Borrowing;

class Profile extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.user.pages.profile';
    protected static ?string $title = 'Profile';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $slug = 'profile';

    public $username;
    public $email;
    public $phone;
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    public $totalUnpaidFines = 0;

    public $totalPaymentAmount = 0;

    public $showPaymentPopup = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;

        $this->totalUnpaidFines = $this->calculateTotalUnpaidFines($user->id);
        $this->totalPaymentAmount = $this->totalUnpaidFines;
    }

    public function payNow()
    {
        $this->showPaymentPopup = true;
    }

    public function closePaymentPopup()
    {
        $this->showPaymentPopup = false;
    }

    protected function calculateTotalUnpaidFines($userId): float
    {
        return Borrowing::where('user_id', $userId)
            ->where('fine_amount', '>', 0)
            ->where('fine_paid', false)
            ->sum('fine_amount');
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('General')
                ->schema([
                    TextInput::make('username')
                        ->label('Name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                ]),
            Section::make('Password')
                ->schema([
                    TextInput::make('old_password')
                        ->label('Old Password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => $state ?: null)
                        ->helperText('Leave empty if you don\'t want to change password'),
                    TextInput::make('new_password')
                        ->label('New Password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => $state ?: null)
                        ->minLength(8)
                        ->same('new_password_confirmation'),
                    TextInput::make('new_password_confirmation')
                        ->label('New Password (Confirm)')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => $state ?: null),
                ]),
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($data['new_password']) {
            if (! $data['old_password'] || ! Hash::check($data['old_password'], $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => 'Old password is incorrect.',
                ]);
            }
        }

        $user->username = $data['username'];
        $user->email = $data['email'];

        if ($data['new_password']) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        Notification::make()
            ->success()
            ->title('Profile updated successfully.')
            ->send();
    }
}
