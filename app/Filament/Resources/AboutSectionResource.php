<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Tables;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'About Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Konten Utama')
                                    ->description('Informasi utama yang akan ditampilkan pada About Section.')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Poin-Poin')
                                    ->description('Tambahkan poin-poin keunggulan atau informasi penting lainnya.')
                                    ->schema([
                                        Repeater::make('points')
                                            ->label('List Poin')
                                            ->schema([
                                                Grid::make(['default' => 1, 'md' => 4])
                                                    ->schema([
                                                        TextInput::make('number')
                                                            ->label('Nomor')
                                                            ->numeric()
                                                            ->required()
                                                            ->default(1)
                                                            ->columnSpan(['default' => 1, 'md' => 1]),

                                                        TextInput::make('title')
                                                            ->label('Judul Poin')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->columnSpan(['default' => 1, 'md' => 3]),

                                                        Textarea::make('description')
                                                            ->label('Deskripsi Poin')
                                                            ->required()
                                                            ->rows(3)
                                                            ->columnSpanFull(),
                                                    ]),
                                            ])
                                            ->defaultItems(3)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),

                        Group::make()
                            ->schema([
                                Section::make('Media')
                                    ->description('Unggah gambar untuk About Section.')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Gambar Utama')
                                            ->image()
                                            ->directory('about-sections')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Visibilitas')
                                    ->description('Atur status ketersediaan section ini.')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->helperText('Tampilkan section ini di halaman utama.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 1]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('points')
                    ->label('Jumlah Poin')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' poin' : '0 poin'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
