<div>
    <button class="btn btn-primary" wire:click="openAddModal">Add New Car</button>

    {{-- Add/Edit Modal --}}
    @include('livewire.modals.car-modal')

    {{-- DataTable --}}
    <table id="cars-table" class="table table-bordered">
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Fuel Type</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
    <script>
        $(function() {
            const table = $('#cars-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('livewire.carForm') }}',
                columns: [{
                        data: 'make',
                        name: 'make'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'fuel_type',
                        name: 'fuel_type'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `<button class="btn btn-sm btn-warning" wire:click="edit(${data})">Edit</button>`;
                        }
                    }
                ]
            });

            // Reinitialize Select2 when modal is shown
            window.addEventListener('car-modal-shown', () => {
                $('#fuel_type').select2().on('change', function() {
                    @this.set('fuel_type', $(this).val());
                });
            });
        });
    </script>
@endpush
