@extends('layouts.app')
@section('page-title')
    {{__('RFID Vehicle')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('RFID Vehicle')}}</a>
        </li>
    </ul>
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('RFID No')}}</th>
                            <th>{{__('Plat Nomor')}}</th>
                            <th>{{__('Kendaraan')}}</th>
                            <th>{{__('Nama')}}</th>
                            <th>{{__('Company')}}</th>
                            <th>{{__('Awal Berlaku')}}</th>
                            <th>{{__('Kadaluarsa')}}</th>
                            <th>{{__('Status')}}</th>
                            @if(Gate::check('edit rfid vehicle') ||  Gate::check('delete rfid vehicle'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicles as $vehicle)

                            <tr role="row">
                                {{-- <td><a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="lg" href="#"
                                                   data-url="{{ route('rfid-extend',$vehicle->id) }}"
                                                   data-title="{{__('Edit RFID Vehicle')}}">{{$vehicle->rfid_no}}</a>
                                </td> --}}
                                <td>{{$vehicle->rfid_no}}</td>
                                <td>{{$vehicle->vehicle_no}}</td>
                                <td>                                     
                                    @if($vehicle->vehicleid == '1')
                                        Mobil
                                    @elseif($vehicle->vehicleid == '2')
                                        Motor
                                    @else
                                        Tidak Diketahui
                                    @endif  
                                </td>
                                <td>{{ $vehicle->name }} </td>
                                <td>{{ $vehicle->company_name }} </td>
                                <td>{{ $vehicle->start_date }} </td>
                                <td>{{ $vehicle->end_date }} </td>
                                <td>
                                    @if(\Carbon\Carbon::parse($vehicle->end_date)->isPast() && \Carbon\Carbon::parse($vehicle->end_date)->lt(\Carbon\Carbon::today()))
                                        <span class="badge badge-danger">{{__('Kadaluarsa')}}</span>
                                    @else
                                        <span class="badge badge-success">{{__('Aktif')}}</span>
                                    @endif
                                </td>
                                @if(Gate::check('edit rfid vehicle') ||  Gate::check('delete rfid vehicle'))
                                <td class="text-right">
                                   
                                <div class="cart-action">
                                    
                                    <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                            data-url="{{ route('rfid-extend.extend',$vehicle->id) }}"
                                            data-title="{{__('Perpanjang')}}">Perpanjang</a>
                                    
                                </div>
                                </td>
                                @endif
                               
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

