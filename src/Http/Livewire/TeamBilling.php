<?php

namespace IdeaToCode\LarapaySmartbill\Http\Livewire;

use Livewire\Component;
use Symfony\Component\Intl\Countries;

class TeamBilling extends Component
{
    public $team;
    public $countries;

    protected function rules()
    {
        return [
            'team.billing_name' => 'required|string|min:6',
            'team.billing_address' => 'required|string|min:6',
            'team.billing_country' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!isset($this->countries[$value])) {
                    $fail('Country not found: ' . $value);
                }
            }],
            'team.billing_code' => 'required|string|min:6',
            // 'post.content' => 'required|string|max:500',
        ];
    }

    public function mount()
    {
        $this->countries = Countries::getNames(config('app.locale'));
    }
    public function render()
    {
        return view('larapay-smartbill::livewire.team-billing');
    }
    public function updateTeamBilling()
    {
        $this->validate();
        $this->team->save();
        $this->emit('saved');
    }
}
