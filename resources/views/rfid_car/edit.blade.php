{{ Form::model($rfidVehiclecar, [
    'route' => ['rfid-vehicle-car.update', $rfidVehiclecar->id],
    'method' => 'PUT'
]) }}
@php
    use Illuminate\Support\Str;
@endphp

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('rfid_no', __('RFID No'), ['class' => 'form-label']) }}
            {{ Form::text('rfid_no', null, ['class' => 'form-control', 'placeholder' => __('Masukkan RFID No')]) }}
        </div>


    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Update'), ['class' => 'btn btn-primary btn-rounded', 'id' => 'submitBtn']) }}
</div>
{{ Form::close() }}

<script>
$(document).ready(function () {
    var member_type = "{{ $rfidVehiclecar->member_type }}"; // Ambil nilai dari Blade
    
    if (member_type) {
        var url = '{{ route("membertype", ":member_type") }}';
        url = url.replace(':member_type', member_type);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                if (data.length > 0) {
                    $('#product_code').val(data[0].keterangan); // Set nilai input dengan keterangan
                }
            },
            error: function () {
                alert("Gagal mengambil data produk.");
            }
        });
    }
});

    // Mencegah enter di field RFID
    $('#rfid_no').on('keydown', function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });

    $('input[name="card_status"]').on('change', function () {
    var rfid_Number = $('#rfid_no').val();

    if ($('#card_lost').is(':checked') || $('#card_damaged').is(':checked')) {
        $('#rfid_no').prop('disabled', false);
        console.log('Enable RFID input');
    } else if ($('#card_blokir').is(':checked')) {
        $('#rfid_no').prop('disabled', false);
        console.log('Blokir Kartu');
        console.log('B'+rfid_Number); 
        $('#rfid_no').val('B'+rfid_Number);
        $('#rfid_no_hidden').val('B'+rfid_Number);
        $('#notes').val('RFID Sebelum Di Blokir : '+rfid_Number);
    } else if ($('#card_activate').is(':checked')) {
        if (rfid_Number.startsWith('B')) {
            $('#rfid_no').prop('disabled', false);
            $('#rfid_no').val(rfid_Number.substring(1));
            $('#rfid_no_hidden').val(rfid_Number.substring(1));
        } else {
            $('#rfid_no').prop('disabled', false);
            $('#rfid_no').val(rfid_Number);
            $('#rfid_no_hidden').val(rfid_Number);
        }
        $('#notes').val('Diaktifkan Kembali');
    } else {
        $('#rfid_no').prop('disabled', true).val('');
        $('#rfid_no_hidden').val('');
    }
});

// Sync value ke hidden saat input berubah
$('#rfid_no').on('input', function () {
    $('#rfid_no_hidden').val($(this).val());
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Processing...'; // opsional untuk UX
    });
});
    

</script>

