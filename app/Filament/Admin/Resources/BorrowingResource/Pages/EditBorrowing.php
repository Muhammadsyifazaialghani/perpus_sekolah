<?php

namespace App\Filament\Admin\Resources\BorrowingResource\Pages;

use App\Filament\Admin\Resources\BorrowingResource;
use Filament\Resources\Pages\EditRecord;

class EditBorrowing extends EditRecord
{
    protected static string $resource = BorrowingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = \App\Models\User::find($data['user_id']);
        if ($user) {
            $data['user_email'] = $user->email;
            $data['class_major'] = $user->class_major;
        }
    
        return $data;
    }
}
