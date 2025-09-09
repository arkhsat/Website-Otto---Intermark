@extends('layouts.app')
@section('page-title')
    {{__('Parking')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Parking')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th class="text-center">{{__('Close Transaction')}}</th>
                            <th class="text-center" style="width: 5%;">{{__('ID')}}</th>
                            <th class="text-center" style="width: 5%;">{{__('Transaction No')}}</th>
                            <th class="text-center">{{__('Kendaraan')}}</th>
                            <th class="text-center">{{__('No Polisi')}}</th>
                            <th class="text-center">{{__('Masuk')}}</th>
                            <th class="text-center">{{__('Status')}}</th>
                            <th class="text-center">{{__('Gambar Kendaraan')}}</th>                    
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parkings as $parking)

                            <tr role="row">

                                <td class="text-center">
                                    <form action="{{ route('parking.close', $parking->transactionid) }}" method="POST" onsubmit="return confirm('Yakin ingin menutup transaksi ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            CLOSE
                                        </button>
                                    </form>
                                </td>
                                
                                <td> {{parkingPrefix().$parking->transactionid}}</td>
                                <td> {{$parking->tiketno}}</td>
                                <td> {{$parking->vehicleid}}  </td>
                                <td> {{$parking->nopolisi}}  </td>
                                <td> {{$parking->datetransact}} </td>
                               
                                <td>
                                    @if($parking->alreadyout=='x')
                                        <span class="badge badge-danger">Keluar</span>
                                    @else
                                        <span class="badge badge-success">Di Area</span>
                                    @endif
                                </td>

                                <td>
                                @if($parking->posinid == '1')
                                    <a href="{{asset('http://192.168.1.55/share/FotoPMLG/'.$parking->image_plate_in)}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                        <img src="{{asset('http://192.168.1.55/share/FotoPMLG/'.$parking->image_plate_in)}}" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                @elseif($parking->posinid == '2')
                                    <a href="{{asset('http://192.168.1.55/share/FotoPMLoading/'.$parking->image_plate_in)}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                        <img src="{{asset('http://192.168.1.55/share/FotoPMLoading/'.$parking->image_plate_in)}}" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                @elseif($parking->posinid == '3')
                                    <a href="{{asset('http://192.168.1.55/share/FotoPMMotor/'.$parking->image_plate_in)}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                        <img src="{{asset('http://192.168.1.55/share/FotoPMMotor/'.$parking->image_plate_in)}}" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                @else
                                    <span class="badge badge-danger">No Image</span>
                                @endif

                                </td>
                              
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

