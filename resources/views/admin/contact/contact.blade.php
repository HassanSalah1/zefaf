@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <form id="search">

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <input type="date" class="form-control" name="date"  id="date-picker"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-3">
                            <button type="submit"
                                    class="btn btn-warning btn-rounded w-md waves-effect waves-light m-b-5">
                                {{trans('admin.search')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                @include('admin.layers.partials.table')
            </div>
        </div><!-- end col -->
    </div>
    <!-- end row -->

@stop

@section('script')
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>

    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>

    <script>
        var edit = false;
        var add = true;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {
            columns = ['name' , 'email', 'subject', 'receive_date', 'actions'];
            url = '{{ url( (($locale === 'ar') ? $locale : '') . "/contacts/data") }}';

            searchContacts(url, columns,
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}'
                });

        });

        // search by query
        function searchContacts(url, keys, lang_obj) {
            loadDataTables(url, keys, '?' + $('#search').serialize(), lang_obj);
            $('#search').on('submit', function (e) {
                e.preventDefault();
                if ($.fn.DataTable.isDataTable('#datatable')) {
                    $('#datatable').DataTable().destroy();
                }
                loadDataTables(url, keys, '?' + $('#search').serialize(), lang_obj);
            });
        }

        function deleteContact(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/contact/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
