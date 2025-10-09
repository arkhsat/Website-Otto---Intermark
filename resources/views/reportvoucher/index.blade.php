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

                    @if(!empty($results))
                    <div style="margin-bottom: 10px;">
                        <a href="{{ route('report.voucher.gelael.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-primary">Download PDF</a>
                        <!-- <a href="{{ route('report.voucher.gelael.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-success">Download Excel</a> -->
                    </div>
                    <table class="display dataTable cell-border">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>0 &gt; x &lt; 1</th>
                                <th>1 &gt; x &lt; 2</th>
                                <th>2 &gt; x &lt; 3</th>
                                <th>3 &gt; x &lt; 4</th>
                                <th>4 &gt; x &lt; 5</th>
                                <th>5 &gt; x &lt; 6</th>
                                <th>6 &gt; x &lt; 7</th>
                                <th>7 &gt; x &lt; 8</th>
                                <th>8 &gt; x &lt; 9</th>
                                <th>9 &gt; x &lt; 10</th>
                                <th>10 &gt; x &lt; 11</th>
                                <th>11 &gt; x &lt; 12</th>
                                <th>12 &gt; x &lt; 13</th>
                                <th>13 &gt; x &lt; 14</th>
                                <th>14 &gt; x &lt; 15</th>
                                <th>15 &gt; x &lt; 16</th>
                                <th>16 &gt; x &lt; 17</th>
                                <th>17 &gt; x &lt; 18</th>
                                <th>18 &gt; x &lt; 19</th>
                                <th>19 &gt; x &lt; 20</th>
                                <th>20 &gt; x &lt; 21</th>
                                <th>21 &gt; x &lt; 22</th>
                                <th>22 &gt; x &lt; 23</th>
                                <th>23 &gt; x &lt; 24</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $parking)

                            <tr role="row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $parking->tanggal }}</td>
                                <td> {{number_formar($result->jam0 ) }}</td>
                                <td> {{number_formar($result->jam1 ) }}</td>
                                <td> {{number_formar($result->jam2 ) }}</td>
                                <td> {{number_formar($result->jam3 ) }}</td>
                                <td> {{number_formar($result->jam4 ) }}</td>
                                <td> {{number_formar($result->jam5 ) }}</td>
                                <td> {{number_formar($result->jam6 ) }}</td>
                                <td> {{number_formar($result->jam7 ) }}</td>
                                <td> {{number_formar($result->jam8 ) }}</td>
                                <td> {{number_formar($result->jam9 ) }}</td>
                                <td> {{number_formar($result->jam10) }} </td>
                                <td> {{number_formar($result->jam11) }} </td>
                                <td> {{number_formar($result->jam12) }} </td>
                                <td> {{number_formar($result->jam13) }} </td>
                                <td> {{number_formar($result->jam14) }} </td>
                                <td> {{number_formar($result->jam15) }} </td>
                                <td> {{number_formar($result->jam16) }} </td>
                                <td> {{number_formar($result->jam17) }} </td>
                                <td> {{number_formar($result->jam18) }} </td>
                                <td> {{number_formar($result->jam19) }} </td>
                                <td> {{number_formar($result->jam20) }} </td>
                                <td> {{number_formar($result->jam21) }} </td>
                                <td> {{number_formar($result->jam22) }} </td>
                                <td> {{number_formar($result->jam23) }} </td>
                                <td> {{number_formar($result->total) }}</td>
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



