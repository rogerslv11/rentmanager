<?php

namespace App\Livewire\Notifications;

use Livewire\Component;

class Dropdown extends Component
{
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->dispatch('toast', type: 'success', message: 'Notificações marcadas como lidas.');
    }

    public function markRead(string $id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->latest()->limit(10)->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();

        return view('livewire.notifications.dropdown', compact('notifications', 'unreadCount'));
    }
}
