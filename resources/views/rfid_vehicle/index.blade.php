@extends('layouts.app')

@section('page-title')
    {{ __('RFID Vehicle') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <h1>{{ __('Dashboard') }}</h1>
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('RFID Vehicle') }}</a>
        </li>
    </ul>
@endsection

@section('card-action-btn')
    @if(Gate::check('create rfid vehicle'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('rfid-vehicle.create') }}"
           data-title="{{ __('Create RFID Vehicle') }}">
            <i class="ti-plus mr-5"></i>{{ __('Create RFID Vehicle') }}
        </a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button id="btnPrint" class="btn btn-info mb-3">Cetak Laporan</button>
                    <button id="btnExcel" class="btn btn-success mb-3">Download Excel</button>
                    <div class="mb-3">
                        <label>
                            <input type="checkbox" id="filterActiveOnly">
                            Tampilkan hanya status Aktif
                        </label>
                    </div>
                    <div class="table-responsive">
                        <table class="display dataTable cell-border datatbl-advance" id="rfidVehicleTable">
                            <thead>
                            <tr>
                                <th>RFID</th>
                                <th>Plat Nomor</th>
                                <th>Kendaraan</th>
                                <th>Nama</th>
                                <th>Company</th>
                                <th>No HP</th>
                                <th>Awal Berlaku</th>
                                <th>Kadaluarsa</th>
                                <th>Status</th>
                                <th>Produk</th>
                                @if(Gate::check('edit rfid vehicle') || Gate::check('delete rfid vehicle'))
                                    <th class="text-right">{{ __('Action') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>
                                        <a class="text-success customModal" data-bs-toggle="tooltip"
                                           data-bs-original-title="{{ __('Edit') }}" data-size="lg" href="#"
                                           data-url="{{ route('rfid-vehicle.edit', $vehicle->id) }}"
                                           data-title="{{ __('Edit RFID Vehicle') }}">
                                            {{ $vehicle->rfid_no }}
                                        </a>
                                    </td>
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                    <td>
                                        @if($vehicle->vehicleid == '1')
                                            Mobil
                                        @elseif($vehicle->vehicleid == '2')
                                            Motor
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td>{{ $vehicle->name }}</td>
                                    <td>{{ $vehicle->company_name }}</td>
                                    <td>{{ $vehicle->phone_number }}</td>
                                    <td>{{ $vehicle->start_date }}</td>
                                    <td>{{ $vehicle->end_date }}</td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($vehicle->end_date)->isPast() && \Carbon\Carbon::parse($vehicle->end_date)->lt(\Carbon\Carbon::today()))
                                            <span class="badge badge-danger">{{ __('Kadaluarsa') }}</span>
                                        @else
                                            <span class="badge badge-success">{{ __('Aktif') }}</span>
                                        @endif

                                        @if(Str::startsWith($vehicle->rfid_no, 'B'))
                                            <br><span class="badge badge-secondary">{{ __('Terblokir') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $vehicle->member_type_keterangan }}</td>
                                    @if(Gate::check('edit rfid vehicle') || Gate::check('delete rfid vehicle'))
                                        <td class="text-right">
                                            <div class="cart-action">
                                                <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{ __('Edit') }}" data-size="lg" href="#"
                                                   data-url="{{ route('rfid-vehicle.edit', $vehicle->id) }}"
                                                   data-title="{{ __('Edit RFID Vehicle') }}">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btnPrint");
    if (btn) {
        btn.addEventListener("click", function () {
            let table = $('#rfidVehicleTable').DataTable();
            let filteredData = table.rows({ search: 'applied' }).nodes();

            let printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>ottoparking</title>');
            printWindow.document.write(`
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 14px; }
                    th { background-color: #f2f2f2; }
                    h2,h3 { text-align: center; }
                </style>
            `);
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Data Member</h2>');
            printWindow.document.write('<h3>Otto Parking - Intermark Indonesia</h3>');

            let ths = $('#rfidVehicleTable thead tr th').slice(1, 8);
            let htmlTable = '<table><thead><tr>';
            ths.each(function () {
                htmlTable += '<th>' + $(this).text() + '</th>';
            });
            htmlTable += '</tr></thead><tbody>';

            for (let i = 0; i < filteredData.length; i++) {
                let cells = $(filteredData[i]).find('td').slice(1, 8);
                htmlTable += '<tr>';
                cells.each(function () {
                    htmlTable += '<td>' + $(this).text() + '</td>';
                });
                htmlTable += '</tr>';
            }

            htmlTable += '</tbody></table>';

            printWindow.document.write(htmlTable);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const btnExcel = document.getElementById("btnExcel");

    if (btnExcel) {
        btnExcel.addEventListener("click", function () {
            let table = $('#rfidVehicleTable').DataTable();
            let filteredData = table.rows({ search: 'applied' }).nodes();

            let ths = $('#rfidVehicleTable thead tr th').slice(1, 8);
            let csvContent = '';
            
            // Header
            ths.each(function () {
                csvContent += '"' + $(this).text().trim() + '",';
            });
            csvContent = csvContent.slice(0, -1); // hapus koma terakhir
            csvContent += "\n";

            // Data
            for (let i = 0; i < filteredData.length; i++) {
                let row = '';
                let cells = $(filteredData[i]).find('td').slice(1, 8);
                cells.each(function () {
                    row += '"' + $(this).text().trim() + '",';
                });
                row = row.slice(0, -1);
                csvContent += row + "\n";
            }

            // Download
            let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "rfid_vehicle.xlsx"; // bisa pakai .csv juga
            link.click();
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {

    $.fn.dataTable.ext.search.push(function (settings, data) {

        let isChecked = document.getElementById('filterActiveOnly').checked;

        // kolom Status = index ke-8
        let statusColumn = data[8] || '';

        // Jika checkbox OFF → tampilkan semua
        if (!isChecked) return true;

        // Jika checkbox ON → hanya Aktif
        return statusColumn.includes('Aktif') &&
               !statusColumn.includes('Kadaluarsa');
    });

    $('#filterActiveOnly').on('change', function () {
        $('#rfidVehicleTable').DataTable().draw();
    });

});


</script>
