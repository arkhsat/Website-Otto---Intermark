@extends('layouts.app')

@section('page-title')
    {{ __('Report Penggunaan Voucher') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><h1>{{ __('Dashboard') }}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Report Penggunaan Voucher') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <style>
        thead th{
            text-align: center;
            background-color: #f4f4f4;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('report.voucher.gelael') }}" method="GET">
                        <div class="form-group col-md-6">
                            {{ Form::label('entry_date', __('Start Date'), ['class' => 'form-label']) }}
                            {{ Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                            {{ Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="submit">Process</button>
                        </div>
                    </form>

                    @if(!empty($hour_out))
                    <div style="margin-bottom: 10px;">
                        <a href="{{ route('report.voucher.gelael.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-primary">Download PDF</a>
                        <a href="{{ route('report.voucher.gelael.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-success">Download Excel</a>
                    </div>
                    <table class="display dataTable cell-border">
                        <thead>
                            <tr>
                                <th rowspan = 3>No</th>
                                <th rowspan = 3>Tanggal</th>
                                <th rowspan = 3>0 &gt; x &lt; 1</th>
                                <th rowspan = 3>1 &gt; x &lt; 2</th>
                                <th rowspan = 3>2 &gt; x &lt; 3</th>
                                <th rowspan = 3>3 &gt; x &lt; 4</th>
                                <th rowspan = 3>4 &gt; x &lt; 5</th>
                                <th rowspan = 3>5 &gt; x &lt; 6</th>
                                <th rowspan = 3>6 &gt; x &lt; 7</th>
                                <th rowspan = 3>7 &gt; x &lt; 8</th>
                                <th rowspan = 3>8 &gt; x &lt; 9</th>
                                <th rowspan = 3>9 &gt; x &lt; 10</th>
                                <th rowspan = 3>10 &gt; x &lt; 11</th>
                                <th rowspan = 3>11 &gt; x &lt; 12</th>
                                <th rowspan = 3>12 &gt; x &lt; 13</th>
                                <th rowspan = 3>13 &gt; x &lt; 14</th>
                                <th rowspan = 3>14 &gt; x &lt; 15</th>
                                <th rowspan = 3>15 &gt; x &lt; 16</th>
                                <th rowspan = 3>16 &gt; x &lt; 17</th>
                                <th rowspan = 3>17 &gt; x &lt; 18</th>
                                <th rowspan = 3>18 &gt; x &lt; 19</th>
                                <th rowspan = 3>19 &gt; x &lt; 20</th>
                                <th rowspan = 3>20 &gt; x &lt; 21</th>
                                <th rowspan = 3>21 &gt; x &lt; 22</th>
                                <th rowspan = 3>22 &gt; x &lt; 23</th>
                                <th rowspan = 3>23 &gt; x &lt; 24</th>
                                <th rowspan = 3>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hour_out as $index => $parking)

                            <tr role="row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $parking->tanggal }}</td>
                                <td> {{number_format($parking->jam0_mobil + $parking->jam0_motor + $parking->jam0_truck) }}</td>
                                <td> {{number_format($parking->jam1_mobil + $parking->jam1_motor + $parking->jam1_truck) }}</td>
                                <td> {{number_format($parking->jam2_mobil + $parking->jam2_motor + $parking->jam2_truck) }}</td>
                                <td> {{number_format($parking->jam3_mobil + $parking->jam3_motor + $parking->jam3_truck) }}</td>
                                <td> {{number_format($parking->jam4_mobil + $parking->jam4_motor + $parking->jam4_truck) }}</td>
                                <td> {{number_format($parking->jam5_mobil + $parking->jam5_motor + $parking->jam5_truck) }}</td>
                                <td> {{number_format($parking->jam6_mobil + $parking->jam6_motor + $parking->jam6_truck) }}</td>
                                <td> {{number_format($parking->jam7_mobil + $parking->jam7_motor + $parking->jam7_truck) }}</td>
                                <td> {{number_format($parking->jam8_mobil + $parking->jam8_motor + $parking->jam8_truck) }}</td>
                                <td> {{number_format($parking->jam9_mobil + $parking->jam9_motor + $parking->jam9_truck) }}</td>
                                <td> {{number_format($parking->jam10_mobil + $parking->jam10_motor + $parking->jam10_truck) }}</td>
                                <td> {{number_format($parking->jam11_mobil + $parking->jam11_motor + $parking->jam11_truck) }}</td>
                                <td> {{number_format($parking->jam12_mobil + $parking->jam12_motor + $parking->jam12_truck) }}</td>
                                <td> {{number_format($parking->jam13_mobil + $parking->jam13_motor + $parking->jam13_truck) }}</td>
                                <td> {{number_format($parking->jam14_mobil + $parking->jam14_motor + $parking->jam14_truck) }}</td>
                                <td> {{number_format($parking->jam15_mobil + $parking->jam15_motor + $parking->jam15_truck) }}</td>
                                <td> {{number_format($parking->jam16_mobil + $parking->jam16_motor + $parking->jam16_truck) }}</td>
                                <td> {{number_format($parking->jam17_mobil + $parking->jam17_motor + $parking->jam17_truck) }}</td>
                                <td> {{number_format($parking->jam18_mobil + $parking->jam18_motor + $parking->jam18_truck) }}</td>
                                <td> {{number_format($parking->jam19_mobil + $parking->jam19_motor + $parking->jam19_truck) }}</td>
                                <td> {{number_format($parking->jam20_mobil + $parking->jam20_motor + $parking->jam20_truck) }}</td>
                                <td> {{number_format($parking->jam21_mobil + $parking->jam21_motor + $parking->jam21_truck) }}</td>
                                <td> {{number_format($parking->jam22_mobil + $parking->jam22_motor + $parking->jam22_truck) }}</td>
                                <td> {{number_format($parking->jam23_mobil + $parking->jam23_motor + $parking->jam23_truck) }}</td>
                                <td> {{number_format($parking->total) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>{{ __('No data available for the selected date range.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

$(document).ready(function() {
    $('.datatbl-advance').DataTable();
});



