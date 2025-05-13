<div class="modal fade" wire:ignore.self id="carModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form wire:submit.prevent="{{ $editing ? 'updateCar' : 'saveCar' }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editing ? 'Edit Car' : 'Add New Car' }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach (['make', 'model', 'year', 'price'] as $field)
                            <div class="col-md-6 mb-3">
                                <label>{{ ucfirst($field) }}</label>
                                <input type="{{ $field == 'price' ? 'number' : 'text' }}"
                                    wire:model.defer="{{ $field }}" class="form-control">
                            </div>
                        @endforeach

                        <div class="col-md-6 mb-3" wire:ignore>
                            <label>Fuel Type</label>
                            <select class="form-control" id="fuel_type">
                                <option value="">-- Select Fuel Type --</option>
                                <option>Petrol</option>
                                <option>Diesel</option>
                                <option>Electric</option>
                                <option>Hybrid</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <h5>Features</h5>
                            @foreach ($features as $index => $feature)
                                <div class="row mb-2">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Feature Name"
                                            wire:model="features.{{ $index }}.name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Description"
                                            wire:model="features.{{ $index }}.description">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger"
                                            wire:click="removeFeature({{ $index }})">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-success" wire:click="addFeature">+ Add
                                Feature</button>
                        </div>

                        <div class="col-12 mt-3">
                            <label>Car Images</label>
                            <input type="file" wire:model="images" multiple class="form-control">
                            @error('images.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">{{ $editing ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
