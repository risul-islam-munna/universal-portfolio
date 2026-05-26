<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Providers\StorageServiceProvider;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings-page';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'General Settings';

    protected static ?int $navigationSort = 100;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $setting = Setting::first();
        $this->form->fill($setting?->data ?? []);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('General')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('site_title')
                                    ->label('Site Title')
                                    ->required()
                                    ->maxLength(200)
                                    ->columnSpanFull(),

                                TextInput::make('tagline')
                                    ->maxLength(300)
                                    ->columnSpanFull(),

                                TextInput::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxLength(500)
                                    ->columnSpanFull(),

                                TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email(),

                                TextInput::make('phone')
                                    ->maxLength(50),

                                TextInput::make('address')
                                    ->maxLength(300)
                                    ->columnSpanFull(),

                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->maxLength(50),
                            ]),
                        ]),

                        Tab::make('Social Media')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('github_url')
                                    ->label('GitHub URL')
                                    ->url()
                                    ->maxLength(500),

                                TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->maxLength(500),

                                TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->maxLength(500),

                                TextInput::make('twitter_url')
                                    ->label('X / Twitter URL')
                                    ->url()
                                    ->maxLength(500),

                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->maxLength(500),

                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->maxLength(500),
                            ]),
                        ]),

                        Tab::make('Storage')->schema([
                            Section::make('Storage Driver')->schema([
                                Select::make('storage_driver')
                                    ->label('Storage Driver')
                                    ->options([
                                        'local' => 'Local (server disk)',
                                        'r2' => 'Cloudflare R2',
                                    ])
                                    ->default('local')
                                    ->live()
                                    ->required(),
                            ]),

                            Section::make('Cloudflare R2 Configuration')
                                ->hidden(fn ($get) => $get('storage_driver') !== 'r2')
                                ->schema([
                                    Grid::make(2)->schema([
                                        TextInput::make('r2_account_id')
                                            ->label('Account ID')
                                            ->maxLength(200),

                                        TextInput::make('r2_bucket')
                                            ->label('Bucket Name')
                                            ->maxLength(200),

                                        TextInput::make('r2_access_key')
                                            ->label('Access Key ID')
                                            ->maxLength(500),

                                        TextInput::make('r2_secret_key')
                                            ->label('Secret Access Key')
                                            ->password()
                                            ->revealable()
                                            ->maxLength(500),

                                        TextInput::make('r2_public_url')
                                            ->label('Public URL')
                                            ->url()
                                            ->placeholder('https://pub-xxx.r2.dev')
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                    ]),
                                ]),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $setting = Setting::firstOrCreate([]);
        $existing = $setting->data ?? [];

        // Merge so that future unknown keys are preserved
        $setting->update(['data' => array_merge($existing, $data)]);

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    public function testR2Connection(): void
    {
        $accountId = Setting::getValue('r2_account_id');
        $accessKey = Setting::getValue('r2_access_key');
        $secretKey = Setting::getValue('r2_secret_key');
        $bucket = Setting::getValue('r2_bucket');

        if (! $accountId || ! $accessKey || ! $secretKey || ! $bucket) {
            Notification::make()
                ->title('Missing R2 credentials')
                ->body('Save your R2 settings first, then test the connection.')
                ->warning()
                ->send();

            return;
        }

        try {
            $disk = StorageServiceProvider::buildR2Disk([
                'account_id' => $accountId,
                'access_key' => $accessKey,
                'secret_key' => $secretKey,
                'bucket' => $bucket,
            ]);

            $testFile = '_portfolio_connection_test_'.time().'.txt';
            $disk->put($testFile, 'ok');
            $disk->delete($testFile);

            Notification::make()
                ->title('R2 connection successful!')
                ->body("Connected to bucket: {$bucket}")
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('R2 connection failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
