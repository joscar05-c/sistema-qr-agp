<?php

namespace App\Filament\Resources\SubAreas;

use App\Filament\Resources\SubAreas\Pages\CreateSubArea;
use App\Filament\Resources\SubAreas\Pages\EditSubArea;
use App\Filament\Resources\SubAreas\Pages\ListSubAreas;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Models\SubArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SubAreaResource extends Resource
{
    protected static ?string $model = SubArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Información de la Sub Área')
                ->schema([
                    Select::make('area_id')
                        ->relationship('area', 'nombre')
                        ->required()
                        ->searchable()
                        ->preload(),
                    TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('oficina')
                        ->maxLength(100)
                        ->hint('Ej: Oficina 204 o Puerta principal'),
                    TextInput::make('codigo_interno')
                        ->maxLength(50),
                    Toggle::make('is_active')
                        ->label('¿Activa?')
                        ->default(true),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('area.nombre')->sortable()->searchable()->badge(),
                Tables\Columns\TextColumn::make('codigo_interno')->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Activo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('area_id')
                    ->relationship('area', 'nombre')
                    ->label('Filtrar por Área'),
            ])
            ->recordActions([ // <-- Actualizado
                EditAction::make(),
                Action::make('imprimir_qr')
                    ->label('QR Oficina')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->url(fn($record) => route('directorio.subarea.qr', $record->id))
                    ->openUrlInNewTab(),
            ])
            ->groupedBulkActions([ // <-- Actualizado
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
            'index' => ListSubAreas::route('/'),
            'create' => CreateSubArea::route('/create'),
            'edit' => EditSubArea::route('/{record}/edit'),
        ];
    }
}
