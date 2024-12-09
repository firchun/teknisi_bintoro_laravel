<div class="btn-group d-flex">
    <button class="btn btn-sm btn-primary" onclick="mapCustomer({{ $customer->id }})">Map</button>
    @if ($customer->diterima == 0)
        <button class="btn btn-sm btn-success" onclick="jadwalCustomer({{ $customer->id }})">Terima</button>
    @else
        <button class="btn btn-sm btn-warning" onclick="jadwalCustomer({{ $customer->id }})">Jadwal</button>
    @endif
</div>
