<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSectionResource\Pages;
use App\Models\HomeSection;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Home Section';

    protected static ?string $modelLabel = 'Home Section';

    protected static ?string $pluralModelLabel = 'Home Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 12])
                    ->schema([
                        // KOLOM KIRI (8 Kolom): Konten Utama & Tombol Aksi
                        Group::make()
                            ->schema([
                                // CARD 1: Konten Utama
                                Section::make('Konten Utama')
                                    ->description('Kelola judul dan deskripsi utama untuk bagian banner beranda.')
                                    ->icon('heroicon-o-document-text')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->placeholder('Contoh: Pengabdian Kepada Masyarakat')
                                            ->helperText('Gunakan kalimat pemikat yang ringkas dan merepresentasikan fokus utama program.')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->placeholder('Tulis deskripsi pengantar yang informatif dan menarik...')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike',
                                                'h2', 'h3', 'bulletList', 'orderedList',
                                                'link', 'undo', 'redo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                // CARD 2: Tombol Aksi
                                Section::make('Tombol Aksi (Call to Action)')
                                    ->description('Atur tombol aksi (CTA) yang muncul di bawah deskripsi banner.')
                                    ->icon('heroicon-o-cursor-arrow-rays')
                                    ->schema([
                                        Grid::make(['default' => 1, 'md' => 2])
                                            ->schema([
                                                Fieldset::make('Tombol Utama (Button 1)')
                                                    ->columns(1)
                                                    ->schema([
                                                        TextInput::make('button_one_text')
                                                            ->label('Teks Tombol')
                                                            ->placeholder('Contoh: Lihat Program')
                                                            ->maxLength(255)
                                                            ->columnSpanFull(),

                                                        TextInput::make('button_one_link')
                                                            ->label('Tautan / URL')
                                                            ->placeholder('Contoh: #programs atau https://...')
                                                            ->maxLength(255)
                                                            ->helperText('Bisa berupa anchor (#section) atau URL web eksternal.')
                                                            ->columnSpanFull(),
                                                    ]),

                                                Fieldset::make('Tombol Sekunder (Button 2)')
                                                    ->columns(1)
                                                    ->schema([
                                                        TextInput::make('button_two_text')
                                                            ->label('Teks Tombol')
                                                            ->placeholder('Contoh: Hubungi Kami')
                                                            ->maxLength(255)
                                                            ->columnSpanFull(),

                                                        TextInput::make('button_two_link')
                                                            ->label('Tautan / URL')
                                                            ->placeholder('Contoh: #contact atau https://wa.me/...')
                                                            ->maxLength(255)
                                                            ->helperText('Bisa berupa anchor (#section) atau URL web eksternal.')
                                                            ->columnSpanFull(),
                                                    ]),
                                            ]),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        // KOLOM KANAN (4 Kolom): Media & Visibilitas
                        Group::make()
                            ->schema([
                                // CARD 3: Media Banner
                                Section::make('Media Banner')
                                    ->description('Unggah gambar ilustrasi utama banner beranda.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Gambar Utama')
                                            ->image()
                                            ->directory('home-sections')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->helperText('Format: PNG, JPG, WEBP • Maksimal 2MB • Rasio rekomendasi 16:9 (1200x675 px)')
                                            ->columnSpanFull(),
                                    ]),

                                // CARD 4: Visibilitas
                                Section::make('Visibilitas')
                                    ->description('Pengaturan status publikasi section.')
                                    ->icon('heroicon-o-eye')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->helperText('Tampilkan section ini di landing page publik.')
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
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
                    ->circular()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('button_one_text')
                    ->label('Tombol 1')
                    ->badge()
                    ->color('gray')
                    ->placeholder('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('button_two_text')
                    ->label('Tombol 2')
                    ->badge()
                    ->color('gray')
                    ->placeholder('-')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua Status')
                    ->trueLabel('Hanya yang Aktif')
                    ->falseLabel('Hanya yang Nonaktif'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Home Section')
            ->emptyStateDescription('Tambahkan home section pertama Anda untuk ditampilkan di landing page.')
            ->emptyStateIcon('heroicon-o-home');
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
