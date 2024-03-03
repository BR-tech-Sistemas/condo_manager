<?php

namespace App\Filament\App\Widgets;

use App\Models\Announcement;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class AnnouncementWidget extends Widget implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static string $view = 'filament.app.widgets.announcement-widget';

    public function openModal()
    {
        $announcements = Filament::getTenant()
            ->announcements()
            ->where('valid_until', '>=', now())
            ->where('show_dashboard', true)
            ->get();

        $cookieName = 'announcement-modal-' . auth()->user()->id;

        if ($announcements->isNotEmpty() and !$this->verifyCookiesForAnnouncements($cookieName, $announcements)) {
            $this->createCookieForAnnouncements($cookieName, $announcements);
            $this->dispatch('open-modal', id: 'announcement-modal');
        }
    }

    public function verifyCookiesForAnnouncements(string $cookieName, Collection $cookiesValues = null): bool
    {
        if ($cookiesValues->isEmpty() or !Cookie::has($cookieName)) {
            return false;
        }

        $announcementsCookies = collect(json_decode(Cookie::get($cookieName), true));

        return $announcementsCookies->pluck('id')->diff($cookiesValues->pluck('id'))->isEmpty();
    }

    public function createCookieForAnnouncements(string $cookieName, Collection $cookiesValues): void
    {
        $expiresOn = Carbon::now()->diffInMinutes($cookiesValues->sortByDesc('valid_until')->first()->valid_until);
        Cookie::queue($cookieName, json_encode($cookiesValues->toArray()), $expiresOn);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Announcement::query()
                    ->where('valid_until', '>=', now())
                    ->where('show_dashboard', true)
                    ->orderBy('valid_until')
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Título'),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->html(),
            ])
            ->defaultSort('valid_until');
    }


}
