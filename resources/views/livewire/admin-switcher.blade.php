{{-- Bootstrap 5 Saul compatible admin switcher --}}
<div class="d-flex align-items-center gap-3">
    <!-- Establishment Selector -->
    <div class="flex-grow-1" style="min-width: 200px;">
        <select id="establishment" wire:change="updateEstablishment($event.target.value)"
            class="form-control form-select form-select-sm">
            <option value="">-- Établissement --</option>
            @forelse ($establishments as $establishment)
                <option value="{{ $establishment['id'] ?? $establishment->id }}" @selected($selectedEstablishment === ($establishment['id'] ?? $establishment->id))>
                    {{ $establishment['name'] ?? $establishment->name }}
                </option>
            @empty
                <option disabled>Aucun établissement</option>
            @endforelse
        </select>
    </div>

    <!-- Academic Year Selector -->
    @if (is_array($academicYears) ? count($academicYears) > 0 : $academicYears->count() > 0)
        <div class="flex-grow-1" style="min-width: 180px;">
            <select id="academic-year" wire:change="updateAcademicYear($event.target.value)"
                class="form-control form-select form-select-sm">
                <option value="">-- Année Académique --</option>
                @foreach ($academicYears as $year)
                    <option value="{{ $year['id'] ?? $year->id }}" @selected($selectedAcademicYear === ($year['id'] ?? $year->id))>
                        {{ $year['title'] ?? $year->title }}
                        @if ($year['is_active'] ?? ($year->is_active ?? false))
                            <span class="badge bg-success ms-1">Active</span>
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    @endif
</div>

{{-- TODO: Add indicator badge when both selection are complete --}}
