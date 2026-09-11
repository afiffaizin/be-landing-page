<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'About Section';

    protected static ?string $modelLabel = 'About Section';

    protected static ?string $pluralModelLabel = 'About Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 12])
                    ->schema([
                        // KOLOM KIRI (8 Kolom): Konten Utama & Poin-Poin
                        Group::make()
                            ->schema([
                                // CARD 1: Konten Utama
                                Section::make('Konten Utama')
                                    ->description('Kelola judul dan deskripsi utama untuk bagian tentang kami.')
                                    ->icon('heroicon-o-document-text')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->placeholder('Contoh: Tentang Program Pengabdian')
                                            ->helperText('Gunakan judul yang jelas dan mencerminkan esensi program.')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->placeholder('Tulis latar belakang dan tujuan program secara lengkap...')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike',
                                                'h2', 'h3', 'bulletList', 'orderedList',
                                                'link', 'undo', 'redo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                // CARD 2: Poin-Poin Program
                                Section::make('Poin-Poin Program')
                                    ->description('Daftar poin keunggulan atau pilar kegiatan pengabdian.')
                                    ->icon('heroicon-o-list-bullet')
                                    ->schema([
                                        Repeater::make('points')
                                            ->label('Daftar Poin Keunggulan')
                                            ->addActionLabel('Tambah Poin Baru')
                                            ->columns(['default' => 1, 'md' => 4])
                                            ->schema([
                                                TextInput::make('number')
                                                    ->label('Nomor')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(1)
                                                    ->columnSpan(['default' => 1, 'md' => 1]),

                                                TextInput::make('title')
                                                    ->label('Judul Poin')
                                                    ->placeholder('Contoh: Pemberdayaan Masyarakat')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(['default' => 1, 'md' => 3]),

                                                Textarea::make('description')
                                                    ->label('Deskripsi Poin')
                                                    ->placeholder('Jelaskan kegiatan atau sasaran dari poin ini...')
                                                    ->required()
                                                    ->rows(3)
                                                    ->columnSpanFull(),
                                            ])
                                            ->defaultItems(1)
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->itemLabel(fn (array $state): ?string => filled($state['title'] ?? null)
                                                ? (filled($state['number'] ?? null) ? "{$state['number']}. " : '') . $state['title']
                                                : 'Poin Baru')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        // KOLOM KANAN (4 Kolom): Media & Visibilitas
                        Group::make()
                            ->schema([
                                // CARD 3: Media Dokumentasi
                                Section::make('Media Dokumentasi')
                                    ->description('Unggah gambar dokumentasi atau ilustrasi section.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Gambar Utama')
                                            ->image()
                                            ->directory('about-sections')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->helperText('Format: PNG, JPG, WEBP • Maksimal 2MB • Rekomendasi rasio 4:3 atau 16:9')
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

                Tables\Columns\TextColumn::make('points')
                    ->label('Jumlah Poin')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' Poin' : '0 Poin'),

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
            ->emptyStateHeading('Belum Ada About Section')
            ->emptyStateDescription('Tambahkan about section pertama Anda untuk ditampilkan di landing page.')
            ->emptyStateIcon('heroicon-o-information-circle');
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
