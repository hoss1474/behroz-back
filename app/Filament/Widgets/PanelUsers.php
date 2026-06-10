<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat; // تغییر از Card به Stat
use App\Models\Contact;
use App\Models\Project;
use App\Models\Blog;

class PanelUsers extends BaseWidget
{
    protected static ?int $sort = 2; // عدد کمتر = اولویت بالاتر (بالاتر نمایش داده می‌شود)
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array // تغییر نام متد از getCards به getStats
    {
        return [
            Stat::make('Number of Contact', Contact::count())
                ->description('Number of Contact')
                ->descriptionIcon('heroicon-m-users') // آیکون کوچک نسخه ۳
                ->color('primary'),

            Stat::make('Number of projects ', Project::count())
                ->description('Number of projects')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),

//            Stat::make('Number of Blogs', Blog::count())
//                ->description('Blog')
//                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
//                ->color('primary'),
        ];
    }
}
