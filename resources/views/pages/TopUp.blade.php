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
                    <label>Basic Example</label>
                        <select class="form-control select2 dtlData" id="kt_select2_1" name="param">
                            <option value="">-- Select Below --</option>
                            @foreach($user as $val)
                                <option value="{{$val->username}}">{{$val->username}} | {{ $val->name }}</option>
                            @endforeach
                        </select>
                    <span class="form-text text-muted">NISN/ NPSN / Nama</span>
                </div>
                <div class="col-1"></div>
                <div class="form-group col-6">
                    <label>Amount:</label>
                    <select class="form-control" name="balance" id="balance">
                        @foreach($setting as $val)
                            <option value="{{ $val->value }}"> {{ $val->value }} </option>
                        @endforeach
                    </select>
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
            var username = $('#kt_select2_1').val();
            var balance = $('#balance').val();
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": username,
                    "balance": balance
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

    // Class definition
    var KTSelect2 = function() {
        // Private functions
        var demos = function() {
            // basic
            $('#kt_select2_1').select2({
                placeholder: "Select User"
            });

            // nested
            $('#kt_select2_2').select2({
                placeholder: "Select a state"
            });

            // multi select
            $('#kt_select2_3').select2({
                placeholder: "Select a state",
            });

            // basic
            $('#kt_select2_4').select2({
                placeholder: "Select a state",
                allowClear: true
            });

            // loading data from array
            var data = [{
                id: 0,
                text: 'Enhancement'
            }, {
                id: 1,
                text: 'Bug'
            }, {
                id: 2,
                text: 'Duplicate'
            }, {
                id: 3,
                text: 'Invalid'
            }, {
                id: 4,
                text: 'Wontfix'
            }];

            $('#kt_select2_5').select2({
                placeholder: "Select a value",
                data: data
            });

            // loading remote data

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                var markup = "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
                if (repo.description) {
                    markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
                }
                markup += "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                    "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                    "</div>" +
                    "</div></div>";
                return markup;
            }

            function formatRepoSelection(repo) {
                return repo.full_name || repo.text;
            }

            $("#kt_select2_6").select2({
                placeholder: "Search for git repositories",
                allowClear: true,
                ajax: {
                    url: "https://api.github.com/search/repositories",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
            });

            // custom styles

            // tagging support
            $('#kt_select2_12_1, #kt_select2_12_2, #kt_select2_12_3, #kt_select2_12_4').select2({
                placeholder: "Select an option",
            });

            // disabled mode
            $('#kt_select2_7').select2({
                placeholder: "Select an option"
            });

            // disabled results
            $('#kt_select2_8').select2({
                placeholder: "Select an option"
            });

            // limiting the number of selections
            $('#kt_select2_9').select2({
                placeholder: "Select an option",
                maximumSelectionLength: 2
            });

            // hiding the search box
            $('#kt_select2_10').select2({
                placeholder: "Select an option",
                minimumResultsForSearch: Infinity
            });

            // tagging support
            $('#kt_select2_11').select2({
                placeholder: "Add a tag",
                tags: true
            });

            // disabled results
            $('.kt-select2-general').select2({
                placeholder: "Select an option"
            });
        }

        var modalDemos = function() {
            $('#kt_select2_modal').on('shown.bs.modal', function() {
                // basic
                $('#kt_select2_1_modal').select2({
                    placeholder: "Select a state"
                });

                // nested
                $('#kt_select2_2_modal').select2({
                    placeholder: "Select a state"
                });

                // multi select
                $('#kt_select2_3_modal').select2({
                    placeholder: "Select a state",
                });

                // basic
                $('#kt_select2_4_modal').select2({
                    placeholder: "Select a state",
                    allowClear: true
                });
            });
        }

        // Public functions
        return {
            init: function() {
                demos();
                modalDemos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTSelect2.init();
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