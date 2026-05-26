<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Projects', Project::count())
                ->description('Total portfolio projects')
                ->color('primary'),

            Stat::make('Skills', Skill::count())
                ->description('Technologies listed')
                ->color('success'),

            Stat::make('Blog Posts', BlogPost::where('is_published', true)->count())
                ->description('Published articles')
                ->color('info'),

            Stat::make('New Messages', $unreadMessages)
                ->description('Unread contact messages')
                ->color($unreadMessages > 0 ? 'warning' : 'gray'),
        ];
    }
}
