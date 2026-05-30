<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use App\Providers\StorageServiceProvider;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;

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
        $settings = Setting::forTheme('default');

        $socialLinks = json_decode($settings['social_links'] ?? 'null', true) ?? [];

        $this->form->fill([
            // General
            'site_title' => $settings['site_title'] ?? null,
            'tagline' => $settings['tagline'] ?? null,
            'meta_description' => $settings['meta_description'] ?? null,
            'favicon' => $settings['favicon'] ?? null,
            'contact_email' => $settings['contact_email'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'address' => $settings['address'] ?? null,
            'google_analytics_id' => $settings['google_analytics_id'] ?? null,

            // Social
            'social_links' => $socialLinks,

            // Storage
            'storage_driver' => $settings['storage_driver'] ?? 'local',
            'r2_account_id' => $settings['r2_account_id'] ?? null,
            'r2_bucket' => $settings['r2_bucket'] ?? null,
            'r2_access_key' => $settings['r2_access_key'] ?? null,
            'r2_secret_key' => $settings['r2_secret_key'] ?? null,
            'r2_public_url' => $settings['r2_public_url'] ?? null,

            // Account (prefixed to prevent collision with settings keys)
            'account_email' => auth()->user()?->email,
        ]);
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
                                    ->maxLength(500),

                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->helperText('Recommended: 32×32 PNG or ICO file.')
                                    ->image()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('80')
                                    ->automaticallyResizeImagesToHeight('80')
                                    ->disk('portfolio')
                                    ->directory('favicons')
                                    ->visibility('public')
                                    ->columnSpanFull(),

                                TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email(),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('+880 1234-567890')
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
                            Repeater::make('social_links')
                                ->label('Social Media Links')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Platform Name')
                                        ->required()
                                        ->placeholder('GitHub')
                                        ->maxLength(100),

                                    TextInput::make('url')
                                        ->label('Profile URL')
                                        ->url()
                                        ->maxLength(500),

                                    Textarea::make('svg_icon')
                                        ->label('SVG Icon')
                                        ->placeholder('<svg viewBox="0 0 24 24" fill="currentColor">...</svg>')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->addActionLabel('Add Social Media')
                                ->collapsible()
                                ->reorderable()
                                ->columnSpanFull(),
                        ]),

                        Tab::make('Account')->schema([
                            Section::make('Admin Credentials')->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('account_email')
                                        ->label('Email Address')
                                        ->email()
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpanFull(),

                                    TextInput::make('account_current_password')
                                        ->label('Current Password')
                                        ->password()
                                        ->revealable()
                                        ->dehydrated(false),

                                    TextInput::make('account_new_password')
                                        ->label('New Password')
                                        ->password()
                                        ->revealable()
                                        ->minLength(8)
                                        ->dehydrated(false),

                                    TextInput::make('account_new_password_confirmation')
                                        ->label('Confirm New Password')
                                        ->password()
                                        ->revealable()
                                        ->same('account_new_password')
                                        ->dehydrated(false),
                                ]),

                                SchemaActions::make([
                                    Action::make('updateAccount')
                                        ->label('Update Account')
                                        ->color('primary')
                                        ->action(fn ($livewire) => $livewire->updateAccount()),
                                ]),
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

                                    SchemaActions::make([
                                        Action::make('testR2Connection')
                                            ->label('Test R2 Connection')
                                            ->color('gray')
                                            ->action(fn ($livewire) => $livewire->testR2Connection()),
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

        // Strip account-tab fields — they are not settings keys
        unset($data['account_email']);

        if (isset($data['social_links']) && is_array($data['social_links'])) {
            $data['social_links'] = json_encode(array_values($data['social_links']));
        }

        Setting::setMany($data);

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    public function updateAccount(): void
    {
        // Password fields are dehydrated(false), so read directly from component state
        $email = $this->data['account_email'] ?? null;
        $currentPassword = $this->data['account_current_password'] ?? null;
        $newPassword = $this->data['account_new_password'] ?? null;

        /** @var User $admin */
        $admin = auth()->user();

        if (! empty($newPassword)) {
            if (! Hash::check((string) $currentPassword, $admin->password)) {
                Notification::make()
                    ->title('Current password is incorrect')
                    ->danger()
                    ->send();

                return;
            }

            $admin->password = Hash::make($newPassword);
        }

        $admin->email = $email;
        $admin->save();

        $this->data['account_current_password'] = null;
        $this->data['account_new_password'] = null;
        $this->data['account_new_password_confirmation'] = null;

        Notification::make()
            ->title('Account updated successfully')
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
