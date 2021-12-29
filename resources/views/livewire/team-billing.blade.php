<div>
    <x-jet-form-section submit="updateTeamBilling">
        <x-slot name="title">
            {{ __('Team Billing Information') }}
        </x-slot>
    
        <x-slot name="description">
            {{ __('The team\'s billing information.') }}
        </x-slot>
    
        <x-slot name="form">
            
            <!-- Billing Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="billing_name">
                    <div class="flex items-center">
                        <span>{{ __('Billing Name') }}</span>
                        <x-lsb-tooltip>
                            <p class="block font-medium text-sm") }}>
                                @lang("This is the company's name, it will appear on invoices")<br>
                                @lang("For individuals it's the full name")
                            </p>
                        </x-lsb-tooltip>
                    </div>
                </x-jet-label>
    
                <x-jet-input id="billing_name"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model.defer="team.billing_name" />
    
                <x-jet-input-error for="team.billing_name" class="mt-2" />
            </div>
            
            <!-- Billing Country -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="billing_country" value="{{ __('Billing Country') }}" />
    
                <select wire:model="team.billing_country" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option></option>
                @foreach ($countries as $code => $country)
                    <option value="{{$code}}">{{$country}}</option>
                @endforeach
                </select>
    
                <x-jet-input-error for="team.billing_country" class="mt-2" />
                
            </div>

            <!-- Billing Address -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="billing_address" value="{{ __('Billing Address') }}" />
    
                <x-jet-input id="billing_address"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model.defer="team.billing_address" autocomplete="address" />
    
                <x-jet-input-error for="team.billing_address" class="mt-2" />
            </div>

            <!-- Billing Code -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="billing_code">
                    <div class="flex items-center">
                        <span>{{ __('Billing Code') }}</span>
                        <x-lsb-tooltip>
                            <p class="block font-medium text-sm") }}>
                                @lang("This is the Company Identification number for companies")<br>
                                @lang("And National Id Number or Social Security Number for Individuals")
                            </p>
                        </x-lsb-tooltip>
                    </div>
                </x-jet-label>

                <x-jet-input id="billing_code"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model.defer="team.billing_code" />
                <x-jet-input-error for="team.billing_code" class="mt-2" />
            </div>  
        </x-slot>
    
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
    
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>

    </x-jet-form-section>
    
</div>