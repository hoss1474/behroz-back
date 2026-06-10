<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Panel users';
    protected static ?string $navigationGroup = 'User management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('email')
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                    ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                    ->visibleOn(Pages\CreateUser::class),

                Forms\Components\Select::make('role')
                    ->label('User role')
                    ->options([
                        'admin' => 'admin',
                        'staff' => 'staff',
                        'user' => 'user',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('email')->label('email'),
                Tables\Columns\TextColumn::make('role')->label('role'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('created_at')
                    ->dateTime('Y/m/d'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }

    public static function canView($record): bool
    {
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return $user && $user->role === 'admin';
    }

}
