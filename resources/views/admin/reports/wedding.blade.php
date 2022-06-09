@extends('admin.layers.partials.master')

@section('content')
    {{-- start row   --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="from">From</label>
                        <input class="form-control" type="date" name="from" id="from">
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="to">To</label>
                        <input class="form-control" type="date" name="to" id="to">
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <button class="btn btn-warning btn-rounded" style="margin-top: 27px;"
                                onclick="search()">
                            Search
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- end row--}}

    @include('admin.layers.partials.table')
@stop



@section('script')
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/dashboard/js/fancybox.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
        let defaultlogo = '{{url('/dashboard/logos/placeholder.jpg')}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            search();
        });

        function search() {
            let lang = {
                'show': '{{trans('admin.show')}}',
                'first': '{{trans('admin.first')}}',
                'last': '{{trans('admin.last')}}',
                'filter': '{{trans('admin.filter')}}',
                'filter_type': '{{trans('admin.type_filter')}}',
                export: true
            };
            let keys =  ['user.name','partner_name', 'wedding_date'];
            let fromDate = $('#from').val();
            let toDate = $('#to').val();
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            let query = '';

            if (fromDate) {
                query += 'from=' + fromDate + '&';
            }
            if (toDate) {
                query += 'to=' + toDate;
            }

            let url = '{{ url( (($locale === 'ar') ? $locale : '') . "/reports/wedding/data") }}';
            loadDataTables(url + '?' + query, keys, '', lang);
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
@stop
