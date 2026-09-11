<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSectionResource\Pages;
use App\Models\HomeSection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Home Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Konten Utama')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike',
                                                'h2', 'h3', 'bulletList', 'orderedList',
                                                'link', 'undo', 'redo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'md' => 8]),

                        Group::make()
                            ->schema([
                                Section::make('Media')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Gambar Utama')
                                            ->image()
                                            ->directory('home-sections')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Visibilitas')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->inline(false)
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'md' => 4]),

                        Section::make('Tombol Aksi')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Fieldset::make('Button 1')
                                            ->schema([
                                                TextInput::make('button_one_text')
                                                    ->label('Teks Button 1')
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                                TextInput::make('button_one_link')
                                                    ->label('Link Button 1')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                            ]),
                                            
                                        Fieldset::make('Button 2')
                                            ->schema([
                                                TextInput::make('button_two_text')
                                                    ->label('Teks Button 2')
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                                TextInput::make('button_two_link')
                                                    ->label('Link Button 2')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),
                            ])
                            ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('button_one_text')
                    ->label('Button 1')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('button_two_text')
                    ->label('Button 2')
                    ->toggleable(),

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
            'index' => Pages\ListHomeSections::route('/'),
            'create' => Pages\CreateHomeSection::route('/create'),
            'edit' => Pages\EditHomeSection::route('/{record}/edit'),
        ];
    }
}
