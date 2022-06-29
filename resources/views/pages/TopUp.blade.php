{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Top Up Balance
                <div class="text-muted pt-2 font-size-sm"></div>
            </h3>
        </div>

    </div>

    <div class="card-body">
        <form class="form">
            <div class="card-body row">
                <div class="form-group col-5">
                    <label>Username:</label>
                    <input type="text" name="username" id='name' class="form-control form-control-solid" placeholder="Enter Username" required />
                    <span class="form-text text-muted">NISN Siswa</span>
                </div>
                <div class="col-1"></div>
                <div class="form-group col-6">
                    <label>Amount:</label>
                    <input type="number" name="balance" id='balance' class="form-control form-control-solid" placeholder="Enter amount" required />
                    <span class="form-text text-muted">Angka 1-9 tanpa Rp ataupun tanda baca lain</span>
                </div>
                <div class="card-footer">
                    <button data-url="{{ route('manage.topUp.check') }}" type="button" class="btn btn-primary mr-2 dtlInfo">Submit</button>
                </div>
            </form>

    </div>

</div>

<!-- Modal-->


@endsection

{{-- Styles Section --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


{{-- Scripts Section --}}
@section('scripts')
{{-- vendors --}}
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

<script>
    $(function() {

        $('.dtlInfo').click(function(e) {
            e.preventDefault();
            var username = $('#name').val();
            var balance = $('#balance').val();
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'POST',
                data:{
                    "_token" : "{{ csrf_token() }}",
                    "username" : username,
                    "balance" : balance
                },
                success: function(res) {
                    $('#myModal .modal-title').html('Detail Top Up');
                    $('#myModal').modal('show');
                    $('#form').html(res.data);
                    $('#form').attr('action', res.action);
                },
                error: function(request, status, error) {
                    console.log(error);
                }
            });
        });

        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>

{{-- page scripts --}}
<script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <form class="form" id="form" method="POST" action="">

                </form>
            </div>
        </div>
    </div>
</div>
@endsection