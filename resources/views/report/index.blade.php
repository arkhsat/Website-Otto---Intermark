@extends('layouts.app')
@section('page-title')
    {{__('Parking Zone')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Report Settlement')}}</a>
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
<td rowspan="2">ID SETTLEMENT</td>
<td rowspan="2">FILE NAME</td>
<td rowspan="2">BUSSINESS DATE</td>
<td rowspan="2">CREATE DATE</td>
<td rowspan="2">CREATED BY</td>
<td rowspan="2">IsSend</td>
<td rowspan="2">SEND DATE</td>
<td rowspan="2">LAST SEND DATE</td>
<td rowspan="2">TOTAL ROW</td>
<td rowspan="2">TOTAL AMOUNT</td>
<td colspan="2">MANDIRI</td>
<td colspan="2">BNI</td>
<td colspan="2">BCA</td>
<td colspan="2">BRI</td>
<td colspan="2">DKI</td>
</tr>
<tr>
<td>ROW</td>
<td>AMOUNT</td>
<td>ROW</td>
<td>AMOUNT</td>
<td>ROW</td>
<td>AMOUNT</td>
<td>ROW</td>
<td>AMOUNT</td>
<td>ROW</td>
<td>AMOUNT</td>
</tr>
                        </thead>
                        <tbody>
                        
                        <tr role="row">
<td >&nbsp;</td>
<td>&nbsp;</td>
<td >&nbsp;</td>
<td>&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

