@extends('layouts.app')
@section('page-title')
    {{__('Parking Report Summary')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Report Summary')}}</a>
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
                        <tr style="height: 16.0pt;">
<td class="xl66" style="height: 32.0pt; width: 65pt;" rowspan="2" width="87" height="42">No</td>
<td class="xl66" style="width: 65pt;" rowspan="2" width="87">Tanggal</td>
<td class="xl65" style="width: 130pt;" colspan="2" width="174">Mandiri</td>
<td class="xl65" style="width: 130pt;" colspan="2" width="174">BCA</td>
<td class="xl65" style="width: 130pt;" colspan="2" width="174">BNI</td>
<td class="xl65" style="width: 130pt;" colspan="2" width="174">BRI</td>
</tr>
<tr style="height: 16.0pt;">
<td style="height: 16.0pt;" height="21">Mobil</td>
<td>Motor</td>
<td>Mobil</td>
<td>Motor</td>
<td>Mobil</td>
<td>Motor</td>
<td>Mobil</td>
<td>Motor</td>
</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

