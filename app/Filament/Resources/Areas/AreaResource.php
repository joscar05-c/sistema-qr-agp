<?php

namespace App\Filament\Resources\Areas;

use App\Filament\Resources\Areas\Pages\CreateArea;
use App\Filament\Resources\Areas\Pages\EditArea;
use App\Filament\Resources\Areas\Pages\ListAreas;
use App\Models\Area;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;

    protected static string|BackedEnum|null $navigationIcon  = 'heroicon-o-building-office-2';
    // protected static ?string $navigationGroup = 'Gestión Institucional';
    protected static ?string $modelLabel = 'Área';
    protected static ?string $pluralModelLabel = 'Áreas';

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detalles del Área')
                ->schema([
                    TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('siglas')
                        ->required()
                        ->maxLength(50),
                    TextInput::make('siglas')
                        ->required()
                        ->maxLength(50),
                    TextInput::make('piso')
                        ->datalist([
                            'Piso 1',
                            'Piso 2',
                            'Piso 3',
                        ])
                        ->maxLength(50)
                        ->hint('Ej: Piso 1'),
                    Forms\Components\Textarea::make('descripcion')
                        ->columnSpanFull(),
                    Forms\Components\ColorPicker::make('color'),
                    Forms\Components\TextInput::make('icono')
                        ->hint('Ejemplo: heroicon-o-academic-cap')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('is_active')
                        ->label('¿Área Activa?')
                        ->default(true),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('siglas')->searchable(),
                Tables\Columns\ColorColumn::make('color'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Activo'),
            ])
            ->filters([
                //
            ])
            ->recordActions([ // <-- Reemplaza a actions()
                EditAction::make(),
            ])
            ->groupedBulkActions([ // <-- Reemplaza a bulkActions()
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListAreas::route('/'),
            'create' => CreateArea::route('/create'),
            'edit' => EditArea::route('/{record}/edit'),
        ];
    }
}
