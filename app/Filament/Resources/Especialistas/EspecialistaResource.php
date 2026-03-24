<?php

namespace App\Filament\Resources\Especialistas;

use App\Filament\Resources\Especialistas\Pages\CreateEspecialista;
use App\Filament\Resources\Especialistas\Pages\EditEspecialista;
use App\Filament\Resources\Especialistas\Pages\ListEspecialistas;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Models\Especialista;
use BackedEnum;
use App\Models\Area;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface; // <-- Nueva clase v5
use chillerlan\QRCode\Common\EccLevel;
use Filament\Actions\Action;

class EspecialistaResource extends Resource
{
    protected static ?string $model = Especialista::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_completo';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Ubicación en el Organigrama')
                ->description('Selecciona el área para filtrar las subáreas correspondientes.')
                ->schema([
                    Select::make('area_virtual_id')
                        ->label('Área Principal')
                        ->options(Area::where('is_active', true)->pluck('nombre', 'id'))
                        ->live()
                        ->afterStateUpdated(fn(callable $set) => $set('sub_area_id', null))
                        ->dehydrated(false),

                    Select::make('sub_area_id')
                        ->label('Sub Área')
                        ->relationship(
                            name: 'subArea',
                            titleAttribute: 'nombre',
                            modifyQueryUsing: fn(Builder $query, callable $get) => $query->where('area_id', $get('area_virtual_id'))->where('is_active', true)
                        )
                        ->required()
                        ->searchable()
                        ->preload()
                        ->disabled(fn(callable $get): bool => ! $get('area_virtual_id')),
                ])->columns(2),

            Section::make('Información Personal y Contacto')
                ->schema([
                    TextInput::make('nombre_completo')->required()->maxLength(255),
                    TextInput::make('dni')->required()->numeric()->maxLength(8),
                    FileUpload::make('foto')->image()->directory('especialistas/fotos')->columnSpanFull(),
                    TextInput::make('correo')->email()->maxLength(255),
                    TextInput::make('celular')->tel()->maxLength(20),
                    TextInput::make('anexo')->maxLength(10),
                ])->columns(2),

            Section::make('Perfil Profesional y Redes')
                ->schema([
                    TextInput::make('cargo')->maxLength(255),
                    TextInput::make('especialidad')->maxLength(255),
                    TextInput::make('horario_atencion')->maxLength(255),
                    TextInput::make('linkedin_url')->url()->maxLength(255),
                    TextInput::make('facebook_url')->url()->maxLength(255),
                ])->columns(2),

            Section::make('Configuración de Visibilidad')
                ->schema([
                    Toggle::make('is_visible')->label('¿Visible en el Directorio Público?')->default(true),
                    TextInput::make('orden')->numeric()->default(0)->hint('Útil para ordenar la jerarquía.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => $record->image_url),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Especialista $record): string => $record->cargo ?? ''),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subArea.nombre')
                    ->label('Sub Área')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_visible')
                    ->label('Visible'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sub_area_id')
                    ->relationship('subArea', 'nombre')
                    ->label('Filtrar por Sub Área'),
            ])
            ->recordActions([ // <-- Actualizado
                EditAction::make(),
                Action::make('ver_qr')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->modalHeading(fn(Especialista $record) => 'Código QR de ' . $record->nombre_completo)
                    ->modalDescription('Escanea este código para ver el perfil público del especialista.')
                    ->modalContent(function (Especialista $record) {

                        $options = new QROptions([
                            'version'      => 5,
                            'outputType'   => QROutputInterface::MARKUP_SVG, // Mantenemos SVG
                            'eccLevel'     => EccLevel::L,
                            'scale'        => 5,
                            'addQuietzone' => true,
                        ]);

                        // Esto nos devuelve: "data:image/svg+xml;base64,PD94..."
                        $qrcodeDataUri = (new QRCode($options))->render($record->public_url);

                        return new HtmlString('
                            <div class="flex flex-col items-center justify-center p-4">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                    <img src="' . $qrcodeDataUri . '" alt="Código QR" class="w-64 h-64 object-contain" />
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">URL Pública:</p>
                                    <a href="' . $record->public_url . '" target="_blank" class="text-sm font-medium text-primary-600 hover:underline">
                                        ' . $record->public_url . '
                                    </a>
                                </div>
                            </div>
                        ');
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar'),
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
            'index' => ListEspecialistas::route('/'),
            'create' => CreateEspecialista::route('/create'),
            'edit' => EditEspecialista::route('/{record}/edit'),
        ];
    }
}
