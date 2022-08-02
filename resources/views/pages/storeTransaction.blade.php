{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

<div class="card card-custom mb-5">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Data Toko {{ $data->name }}
                <div class="text-muted pt-2 font-size-sm"></div>
            </h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Dropdown-->
        </div>
    </div>

    <div class="card-body row" style="overflow-x: auto ;">
        <div class="col-12">
            <div class="card bg-success card-statistic-2">
                <div class="card-stats">
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Saldo Anda</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($data->balance,0,'','.') }}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-6 mt-5">
            <form method="POSt" action="{{ route('manage.store.retrieve' , $data->id) }}">
                @csrf
                <div class="form-group col-12">
                    <label>Tarik Saldo</label>
                    <input type="number" name="amount" placeholder="Masukkan Jumlah" class="form-control" required>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>


    </div>

</div>

<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Data Penghasilan {{ $data->name }}
                <div class="text-muted pt-2 font-size-sm"></div>
            </h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Dropdown-->
        </div>
    </div>

    <div class="card-body row" style="overflow-x: auto ;">
        <div class="col-6">
            <div class="card bg-success card-statistic-2">
                <div class="card-stats">
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penghasilan Anda Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($earning_today,0,'','.') }}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-6">
            <div class="card bg-success card-statistic-2">
                <div class="card-stats">
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penghasilan Total Anda</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($earning_total,0,'','.') }}
                    </div>
                </div>

            </div>
        </div>

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
    var KTBootstrapSwitch = function() {

        // Private functions
        var demos = function() {
            // minimum setup
            $('[data-switch=true]').bootstrapSwitch();
        };

        return {
            // public functions
            init: function() {
                demos();
            },
        };
    }();

    jQuery(document).ready(function() {
        KTBootstrapSwitch.init();
    })
</script>

<script>
    $(function() {

        $('.table').on('click', '.dtlInfo', function(e) {
            e.preventDefault();
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    $('#myModal .modal-title').html('Update Menu ');
                    $('#myModal').modal('show');
                    $('#form').html(res.data);
                    $('#form').attr('action', res.action);
                    jQuery(document).ready(function() {
                        KTBootstrapSwitch.init();
                    })
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
@endsection