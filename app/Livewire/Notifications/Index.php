<?php

namespace App\Livewire\Notifications;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Notificações')]
class Index extends Component
{
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->dispatch('toast', type: 'success', message: 'Todas marcadas como lidas.');
    }

    public function markRead($id)
    {
        auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();
    }

    public function delete($id)
    {
        auth()->user()->notifications()->where('id', $id)->first()?->delete();
        $this->dispatch('toast', type: 'success', message: 'Notificação removida.');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        $this->dispatch('toast', type: 'success', message: 'Notificações limpas.');
    }

    public function render()
    {
        $user = auth()->user();
        $allNotifications = $user->notifications()->paginate(20);
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
            'week' => $user->notifications()->whereBetween('created_at', [now()->subDays(7), now()])->count(),
        ];

        return view('livewire.notifications.index', compact('allNotifications', 'stats'));
    }
}
