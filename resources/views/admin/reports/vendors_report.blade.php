@extends('admin.layers.partials.master')

@section('content')
    {{-- start row   --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Main Category</label>
                        <select id="main_category_id" class="form-control" name="main_category_id">
                            <option value="-1">none</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Sub Category</label>
                        <select id="category_id" class="form-control" name="category_id">
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="vendor_id">Vendors</label>
                        <select name="vendor_id" id="vendor_id">
                            <option @if(isset($vendor_id) && $vendor_id == -1) selected @endif value="-1">All</option>
                            @foreach($vendors as $vendor)
                                <option @if(isset($vendor_id) && $vendor_id == $vendor->id) selected @endif
                                value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="from">From</label>
                        <input class="form-control" type="date" name="from" id="from"
                               @if (isset($from))
                               value="{{$from}}"
                            @endif >
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="to">To</label>
                        <input class="form-control" type="date" name="to" id="to"
                               @if (isset($to))
                               value="{{$to}}"
                            @endif >
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

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Clicks</th>
                        <th>Visits</th>
                        <th>Likes</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$vendors_reports['clicks']}}</td>
                        <td>{{$vendors_reports['visits']}}</td>
                        <td>{{$vendors_reports['likes']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <h4>Profile Visits</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($vendors_reports['visit_details']) > 0)
                        @foreach($vendors_reports['visit_details'] as $click)
                            <tr>
                                <td>{{$click['month']}}</td>
                                <td>{{$click['count']}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                No data found
                            </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <h4>Contact Clicks</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($vendors_reports['click_details']) > 0)
                        @foreach($vendors_reports['click_details'] as $click)
                            <tr>
                                <td>{{$click['month']}}</td>
                                <td>{{$click['count']}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                No data found
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <h4>Profile Likes</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($vendors_reports['like_details']) > 0)
                        @foreach($vendors_reports['like_details'] as $click)
                            <tr>
                                <td>{{$click['month']}}</td>
                                <td>{{$click['count']}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                No data found
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop



@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script>

        $(function () {
            $('#vendor_id').select2();
            $('#category_id').select2();
            $('#main_category_id').select2();

            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                console.log(category);
                let form = new FormData();
                form.append('category_id', category);

                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . "/vendors/get/categories")}}',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        let categoryHtml = '<option value="-1">none</option>';
                        response.data.forEach((category) => {
                            categoryHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#category_id').html(categoryHtml);
                        $('#category_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            $('#category_id').on('change', (e) => {
                const category = $('#category_id').find('option:selected').val();
                let form = new FormData();
                form.append('category_id', category);

                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . "/category/get/vendors")}}',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        let categoryHtml = '<option value="-1">All</option>';
                        response.data.forEach((category) => {
                            categoryHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#vendor_id').html(categoryHtml);
                        $('#vendor_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });
        });

        function search() {

            let fromDate = $('#from').val();
            let toDate = $('#to').val();
            let vendor_id = $('#vendor_id').find('option:selected').val();
            let query = '';

            if (vendor_id) {
                query += 'vendor_id=' + vendor_id + '&';
            }
            if (fromDate) {
                query += 'from=' + fromDate + '&';
            }
            if (toDate) {
                query += 'to=' + toDate;
            }
            window.location.href = '{{ url("reports/vendors") }}' + '?' + query;
        }


    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">

@stop
