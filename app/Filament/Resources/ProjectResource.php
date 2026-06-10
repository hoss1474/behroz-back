<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationLabel = 'Projects';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                    ->label('Category')
                    ->nullable()
                    ->required()
                    ->options([
                        'Fashion Films' => 'Fashion Films',
                        'Commercial & Advertising' => 'Commercial & Advertising',
                        'Music Videos' => 'Music Videos',
                        'Experimental & Art Videos' => 'Experimental & Art Videos',
                        'Social Media Content' => 'Social Media Content',
                        'Cosmetics & Beauty' => 'Cosmetics & Beauty',
                    ])
                    ->searchable(),

                TextInput::make('project_name')
                    ->nullable()
                    ->required()
                    ->maxLength(255)
                    ->label('Project Name'),

                Textarea::make('description')
                    ->nullable()
                    ->required()
                    ->label('Description'),

                TextInput::make('client')
                    ->nullable()
                    ->required()
                    ->maxLength(255)
                    ->label('Client'),

                DatePicker::make('data')
                    ->nullable()
                    ->required()
                    ->label('Date'),

                TextInput::make('director')
                    ->nullable()
                    ->required()
                    ->maxLength(255)
                    ->label('Director'),

                FileUpload::make('video_upload')
                    ->label('Upload Video (MP4/MOV)')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                    ->disk('public')
                    ->directory('uploads/videos')
                    ->nullable()
                    ->required()
                    ->multiple(false)
                    ->storeFiles(true)
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file) => $file->getClientOriginalName()
                    )
                    ->enableOpen(),

                Textarea::make('cast')
                    ->nullable()
                    ->required()
                    ->label('Cast and Crew'),

                FileUpload::make('color_grade_before')
                    ->label('Color Grade (Before)')
                    ->image()
                    ->disk('public')
                    ->directory('uploads/color-grade')
                    ->nullable()
                    ->multiple(false)
                    ->storeFiles(true)
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file) => $file->getClientOriginalName()
                    )
                    ->enableOpen()
                    ->required()
                    ->enableDownload(),

                FileUpload::make('color_grade_after')
                    ->label('Color Grade (After)')
                    ->image()
                    ->disk('public')
                    ->directory('uploads/color-grade')
                    ->nullable()
                    ->multiple(false)
                    ->storeFiles(true)
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file) => $file->getClientOriginalName()
                    )
                    ->enableOpen()
                    ->required()
                    ->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')->sortable()->searchable()->label('Category'),
                TextColumn::make('project_name')->sortable()->searchable()->label('Project Name'),
                TextColumn::make('client')->label('Client'),
                TextColumn::make('director')->label('Director'),
                TextColumn::make('video_upload')
                    ->label('Video')
                    ->formatStateUsing(fn ($state) => $state ? '<a href="' . $state . '" target="_blank">View Video</a>' : '-')
                    ->html(),
                TextColumn::make('created_at')->dateTime()->label('Created At'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
