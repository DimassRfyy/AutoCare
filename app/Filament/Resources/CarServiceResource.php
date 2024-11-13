<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarServiceResource\Pages;
use App\Filament\Resources\CarServiceResource\RelationManagers;
use App\Models\CarService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarServiceResource extends Resource
{
    protected static ?string $model = CarService::class;

    protected static ?string $navigationGroup = 'Service & Store Management';

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->helperText('Gunakan nama layanan yang sesuai bisnis Anda.')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),

                Forms\Components\TextInput::make('duration_in_hour')
                    ->required()
                    ->numeric(),

                Forms\Components\FileUpload::make('icon')
                    ->required()
                    ->directory('PhotoService')
                    ->image(),

                Forms\Components\Textarea::make('about')
                    ->required()
                    ->rows(10)
                    ->cols(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                Tables\Columns\ImageColumn::make('icon')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarServices::route('/'),
            'create' => Pages\CreateCarService::route('/create'),
            'edit' => Pages\EditCarService::route('/{record}/edit'),
        ];
    }
}
