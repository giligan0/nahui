<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $place?->name)" autocomplete="name" placeholder="Name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="place_category_id" :value="__('Place Category Id')"/>
        <x-text-input id="place_category_id" name="place_category_id" type="text" class="mt-1 block w-full" :value="old('place_category_id', $place?->place_category_id)" autocomplete="place_category_id" placeholder="Place Category Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('place_category_id')"/>
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $place?->description)" autocomplete="description" placeholder="Description"/>
        <x-input-error class="mt-2" :messages="$errors->get('description')"/>
    </div>
    <div>
        <x-input-label for="address_id" :value="__('Address Id')"/>
        <x-text-input id="address_id" name="address_id" type="text" class="mt-1 block w-full" :value="old('address_id', $place?->address_id)" autocomplete="address_id" placeholder="Address Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('address_id')"/>
    </div>
    <div>
        <x-input-label for="is_public" :value="__('Is Public')"/>
        <x-text-input id="is_public" name="is_public" type="text" class="mt-1 block w-full" :value="old('is_public', $place?->is_public)" autocomplete="is_public" placeholder="Is Public"/>
        <x-input-error class="mt-2" :messages="$errors->get('is_public')"/>
    </div>
    <div>
        <x-input-label for="is_managed" :value="__('Is Managed')"/>
        <x-text-input id="is_managed" name="is_managed" type="text" class="mt-1 block w-full" :value="old('is_managed', $place?->is_managed)" autocomplete="is_managed" placeholder="Is Managed"/>
        <x-input-error class="mt-2" :messages="$errors->get('is_managed')"/>
    </div>
    <div>
        <x-input-label for="managing_org_id" :value="__('Managing Org Id')"/>
        <x-text-input id="managing_org_id" name="managing_org_id" type="text" class="mt-1 block w-full" :value="old('managing_org_id', $place?->managing_org_id)" autocomplete="managing_org_id" placeholder="Managing Org Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('managing_org_id')"/>
    </div>
    <div>
        <x-input-label for="hours" :value="__('Hours')"/>
        <x-text-input id="hours" name="hours" type="text" class="mt-1 block w-full" :value="old('hours', $place?->hours)" autocomplete="hours" placeholder="Hours"/>
        <x-input-error class="mt-2" :messages="$errors->get('hours')"/>
    </div>
    <div>
        <x-input-label for="accessibility_notes" :value="__('Accessibility Notes')"/>
        <x-text-input id="accessibility_notes" name="accessibility_notes" type="text" class="mt-1 block w-full" :value="old('accessibility_notes', $place?->accessibility_notes)" autocomplete="accessibility_notes" placeholder="Accessibility Notes"/>
        <x-input-error class="mt-2" :messages="$errors->get('accessibility_notes')"/>
    </div>
    <div>
        <x-input-label for="entrance_fee" :value="__('Entrance Fee')"/>
        <x-text-input id="entrance_fee" name="entrance_fee" type="text" class="mt-1 block w-full" :value="old('entrance_fee', $place?->entrance_fee)" autocomplete="entrance_fee" placeholder="Entrance Fee"/>
        <x-input-error class="mt-2" :messages="$errors->get('entrance_fee')"/>
    </div>
    <div>
        <x-input-label for="currency" :value="__('Currency')"/>
        <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-full" :value="old('currency', $place?->currency)" autocomplete="currency" placeholder="Currency"/>
        <x-input-error class="mt-2" :messages="$errors->get('currency')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>