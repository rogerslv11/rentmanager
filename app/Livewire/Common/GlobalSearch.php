<?php

namespace App\Livewire\Common;

use App\Models\Contract;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Tenant;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';

    public bool $open = false;

    protected $listeners = ['open-command-palette' => 'show'];

    public function show()
    {
        $this->open = true;
    }

    public function hide()
    {
        $this->open = false;
    }

    public function go(string $url)
    {
        $this->open = false;

        return redirect()->to($url);
    }

    public function render()
    {
        $results = collect();
        if (strlen($this->query) >= 2) {
            $q = '%'.$this->query.'%';

            $properties = Property::where(function ($qry) use ($q) {
                $qry->where('name', 'like', $q)
                    ->orWhere('code', 'like', $q);
            })
                ->limit(5)->get()
                ->map(fn ($p) => [
                    'type' => 'Imóvel',
                    'icon' => 'building-2',
                    'title' => $p->name,
                    'subtitle' => $p->code,
                    'url' => route('properties.show', $p),
                ]);

            $tenants = Tenant::where(function ($qry) use ($q) {
                $qry->where('name', 'like', $q)
                    ->orWhere('tax_id', 'like', $q);
            })
                ->limit(5)->get()
                ->map(fn ($t) => [
                    'type' => 'Inquilino',
                    'icon' => 'user-round',
                    'title' => $t->name,
                    'subtitle' => $t->tax_id,
                    'url' => route('tenants.show', $t),
                ]);

            $owners = Owner::where(function ($qry) use ($q) {
                $qry->where('name', 'like', $q)
                    ->orWhere('tax_id', 'like', $q);
            })
                ->limit(5)->get()
                ->map(fn ($o) => [
                    'type' => 'Proprietário',
                    'icon' => 'user',
                    'title' => $o->name,
                    'subtitle' => $o->tax_id,
                    'url' => route('owners.show', $o),
                ]);

            $contracts = Contract::where('number', 'like', $q)->limit(5)->get()
                ->map(fn ($c) => [
                    'type' => 'Contrato',
                    'icon' => 'file-text',
                    'title' => $c->number,
                    'subtitle' => $c->property->name,
                    'url' => route('contracts.show', $c),
                ]);

            $results = collect()
                ->merge($properties)
                ->merge($tenants)
                ->merge($owners)
                ->merge($contracts);
        }

        return view('livewire.common.global-search', compact('results'));
    }
}
