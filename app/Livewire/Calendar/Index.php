<?php

namespace App\Livewire\Calendar;

use App\Models\Charge;
use App\Models\Contract;
use App\Models\InsurancePolicy;
use App\Models\MaintenanceRequest;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Calendário')]
class Index extends Component
{
    public string $view = 'month';

    public string $currentDate;

    public function mount()
    {
        $this->currentDate = now()->format('Y-m-d');
    }

    public function previousMonth()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subMonth()->format('Y-m-d');
    }

    public function nextMonth()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->addMonth()->format('Y-m-d');
    }

    public function goToToday()
    {
        $this->currentDate = now()->format('Y-m-d');
    }

    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function render()
    {
        $refDate = Carbon::parse($this->currentDate);
        $now = now();

        // Window: prev week to +60 days for upcoming events list
        $windowStart = $now->copy()->subDays(7)->startOfDay();
        $windowEnd = $now->copy()->addDays(120)->endOfDay();

        $events = collect();

        Charge::with(['tenant', 'property'])
            ->whereIn('status', ['pending', 'partially_paid', 'overdue'])
            ->whereBetween('due_date', [$windowStart, $windowEnd])
            ->get()
            ->each(function ($c) use ($events) {
                $events->push([
                    'date' => $c->due_date->format('Y-m-d'),
                    'title' => 'Cobrança - '.$c->tenant->name,
                    'subtitle' => $c->property->name ?? '',
                    'type' => 'charge',
                    'icon' => 'receipt',
                    'color' => '#F59E0B',
                    'url' => route('charges.index'),
                    'datetime' => $c->due_date,
                ]);
            });

        Contract::with('property')
            ->where('status', 'active')
            ->whereBetween('end_date', [$now, $now->copy()->addDays(120)])
            ->get()
            ->each(function ($c) use ($events) {
                $events->push([
                    'date' => $c->end_date->format('Y-m-d'),
                    'title' => 'Vencimento - '.$c->number,
                    'subtitle' => $c->property->name ?? '',
                    'type' => 'contract',
                    'icon' => 'file-text',
                    'color' => '#22C55E',
                    'url' => route('contracts.show', $c),
                    'datetime' => $c->end_date,
                ]);
            });

        InsurancePolicy::with('property')
            ->where('is_active', true)
            ->whereBetween('end_date', [$now, $now->copy()->addDays(120)])
            ->get()
            ->each(function ($p) use ($events) {
                $events->push([
                    'date' => $p->end_date->format('Y-m-d'),
                    'title' => 'Vencimento seguro',
                    'subtitle' => $p->property->name ?? '',
                    'type' => 'insurance',
                    'icon' => 'shield',
                    'color' => '#3B82F6',
                    'url' => route('insurance.index'),
                    'datetime' => $p->end_date,
                ]);
            });

        MaintenanceRequest::with('property')
            ->whereNotNull('scheduled_for')
            ->whereBetween('scheduled_for', [$windowStart, $now->copy()->addDays(60)])
            ->get()
            ->each(function ($m) use ($events) {
                $events->push([
                    'date' => $m->scheduled_for->format('Y-m-d'),
                    'title' => $m->title,
                    'subtitle' => $m->property->name ?? '',
                    'type' => 'maintenance',
                    'icon' => 'wrench',
                    'color' => '#A855F7',
                    'url' => route('maintenance.show', $m),
                    'datetime' => $m->scheduled_for,
                ]);
            });

        $eventsByDate = $events->groupBy('date');

        // Calendar grid for current month
        $firstDay = $refDate->copy()->startOfMonth();
        $daysInMonth = $refDate->daysInMonth;
        $startDay = $firstDay->dayOfWeek;
        $monthLabel = $refDate->translatedFormat('F Y');
        $today = now()->format('Y-m-d');

        // Upcoming events (next 30 days), grouped by type for sidebar
        $upcoming = $events
            ->filter(fn ($e) => $e['datetime'] >= $now)
            ->sortBy('datetime')
            ->take(15)
            ->values();

        // Stats by type
        $stats = [
            'total' => $events->count(),
            'charges' => $events->where('type', 'charge')->count(),
            'contracts' => $events->where('type', 'contract')->count(),
            'insurance' => $events->where('type', 'insurance')->count(),
            'maintenance' => $events->where('type', 'maintenance')->count(),
            'this_week' => $events->filter(fn ($e) => $e['datetime']->isBetween($now, $now->copy()->addDays(7)))->count(),
        ];

        return view('livewire.calendar.index', compact(
            'events',
            'eventsByDate',
            'monthLabel',
            'firstDay',
            'daysInMonth',
            'startDay',
            'today',
            'upcoming',
            'stats',
            'refDate',
        ));
    }
}
