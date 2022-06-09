@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label"
                                   for="user_id">{{trans('admin.user_name')}}</label>
                            <select id="user_id" class="form-control custom-select" name="user_id"
                                    data-placeholder="{{trans('admin.user_name')}}">
                                @foreach($users as $userObj)
                                    <option value="{{$userObj->id}}">{{$userObj->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="control-label"
                                   for="branch_id">{{trans('admin.branch_name')}}</label>
                            <select id="branch_id" class="form-control custom-select" name="branch_id"
                                    data-placeholder="{{trans('admin.branch_name')}}">
                                @foreach($branches as $branch)
                                    <option
                                        value="{{$branch->id}}">{{$branch->city()->name . ' - ' .$branch->address}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label"
                                   for="category_id">{{trans('admin.category_name')}}</label>
                            <select id="category_id" class="form-control custom-select" name="category_id"
                                    data-placeholder="{{trans('admin.category_name')}}">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <hr>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{trans('admin.meal_name')}}</th>
                                <th>{{trans('admin.bread_name')}}</th>
                                <th>{{trans('admin.size_name')}}</th>
                                <th>{{trans('admin.addition_name')}}</th>
                                <th>{{trans('admin.quantity')}}</th>
                                <th>{{trans('admin.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="allMeals">
                            @foreach($meals as $key => $meal)
                                <tr id="meal_{{$key}}">
                                    <td>{{$meal->name}}</td>
                                    <td>
                                        @if (count($meal->breads) > 0)
                                            {{--  bread name  --}}
                                            <select class="form-control" id="select_bread_id_{{$key}}">
                                                @foreach($meal->breads as $bread)
                                                    <option value="{{$bread->id}}">{{$bread->name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{trans('admin.not_found')}}
                                        @endif

                                    </td>
                                    <td>
                                        @if (count($meal->sizes) > 0)
                                            {{--  size name  --}}
                                            <select class="form-control" id="select_size_id_{{$key}}">
                                                @foreach($meal->sizes as $size)
                                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{trans('admin.not_found')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (count($meal->additions) > 0)
                                            {{--  addition name  --}}
                                            <select class="form-control" id="select_addition_id_{{$key}}">
                                                @foreach($meal->additions as $addition)
                                                    <option value="{{$addition->id}}">{{$addition->name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{trans('admin.not_found')}}
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" placeholder="{{trans('admin.quantity')}}"
                                               class="form-control" id="quantity_{{$key}}">
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="addToCart('{{$key}}')">
                                            {{trans('admin.add_cart')}}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <h3><b>{{trans('admin.cart')}}</b></h3>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{trans('admin.meal_name')}}</th>
                                <th>{{trans('admin.bread_name')}}</th>
                                <th>{{trans('admin.size_name')}}</th>
                                <th>{{trans('admin.addition_name')}}</th>
                                <th>{{trans('admin.quantity')}}</th>
                                <th>{{trans('admin.price')}}</th>
                                <th>{{trans('admin.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="cartMeals">

                            </tbody>
                        </table>
                    </div>

                    <br>

                    <div class="row">

                        <div class="form-group col-md-4 offset-4">
                            <button type="submit"
                                    class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                {{trans('admin.save')}}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@stop



@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script src="{{url('/dashboard/js/fancybox.min.js')}}"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>
        let meals = [];
        let cart = [];

        $(function () {
            meals = <?php echo $meals ?>;
            $('#user_id').select2();
            $('#category_id').select2();
            $('#branch_id').select2();

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/meal/add')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('meals')}}'
                    });
            });

            $('#branch_id').change(function (e) {
                if (cart.length > 0) {
                    swal({
                        title: '{{trans('admin.change_branch')}}',
                        text: '{{trans('admin.change_branch_message')}}',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-warning',
                        confirmButtonText: '{{trans('admin.ok')}}',
                        cancelButtonText: '{{trans('admin.cancel')}}',
                        closeOnConfirm: false
                    }, function () {
                        changeMeals();
                    });
                } else {
                    changeMeals();
                }
            });

            $('#category_id').change(function (e) {
                changeMeals();
            });
        });

        function changeMeals() {
            const form = new FormData();
            const branch = $('#branch_id').find('option:selected').val();
            const category = $('#category_id').find('option:selected').val();
            form.append('branch_id', branch);
            form.append('category_id', category);
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/get/meals')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    let row = meals.length;
                    let tableBody = '';
                    response.data.forEach( (meal) => {
                       tableBody += generateMealRow(meal , row++);
                    });
                    $('#allMeals').html(tableBody);
                    meals.concat(response.data);
                },
                error: function () {
                    $('#allMeals').html('');
                }
            });
        }

        function addToCart(key) {
            const meal = meals[key];
            const quantity = $('#quantity_' + key).val();
            if (quantity > 0) {
                meal.quantity = quantity;
                const bread_id = $('#select_bread_id_' + key).find('option:selected').val();
                const size_id = $('#select_size_id_' + key).find('option:selected').val();
                $('#meal_' + key).hide();
                meal.selected = {
                    bread_id: (bread_id) ? parseInt(bread_id) : null,
                    size_id: (size_id) ? parseInt(size_id) : null,

                }
                cart.push(meal);
                // generate row in cart view
                generateCartRaw(meal, key);
            } else {
                toastr['error']('{{trans('admin.enter_quantity_message')}}', '{{trans('admin.error_title')}}');
            }
        }

        function generateCartRaw(meal, mealRowKey) {
            let price = meal.price;
            let size = null;
            let bread = null;
            if (meal.selected.size_id !== null) {
                size = meal.sizes.find((size) => size.id === meal.selected.size_id);
                price = (size) ? size.price : 0;
            }
            if (meal.selected.bread_id !== null) {
                bread = meal.breads.find((bread) => bread.id === meal.selected.bread_id);
                price = (bread) ? bread.price : 0;
            }
            const row = '<tr id="cart_meal_' + meal.id + '">' +
                '<td>' + meal.name + '</td>' +
                '<td>' + ((bread) ? bread.name : '') + '</td>' +
                '<td>' + ((size) ? size.name : '') + '</td>' +
                '<td>' + '' + '</td>' +
                '<td>' + meal.quantity + '</td>' +
                '<td>' + (meal.quantity * price) + '</td>' +
                '<td><button type="button" class="btn btn-danger" onclick="deleteCartItem(' + meal.id + ',' + mealRowKey + ')"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            $('#cartMeals').append(row);
        }

        function deleteCartItem(mealId, mealRowKey) {
            const mealIndex = cart.findIndex((meal) => meal.id === mealId);
            if (mealIndex !== -1) {
                cart.splice(mealIndex, 1);
                $('#cart_meal_' + mealId).remove();
                $('#meal_' + mealRowKey).show();
            }
        }

        function generateMealRow(meal, key) {
            let html = '<tr id="meal_' + key + '">' +
                '          <td>' + meal.name + '</td>' +
                '          <td>';
            if (meal.breads.length > 0) {
                html += '<select class="form-control" id="select_bread_id_' + key + '">';
                meal.breads.forEach((bread) => {
                    html += '<option value="' + bread.id + '">' + bread.name + '</option>';
                });
                html += '</select>';
            } else {
                html += '{{trans('admin.not_found')}}';
            }
            html += '</td>' +
                '<td>';
            if (meal.sizes.length > 0) {
                html += '<select class="form-control" id="select_size_id_' + key + '">';
                meal.sizes.forEach((size) => {
                    html += '<option value="' + size.id + '">' + size.name + '</option>';
                });
                html += '</select>';
            } else {
                html += '{{trans('admin.not_found')}}';
            }
            html += '</td>' +
                '<td>';

            if (meal.additions.length > 0) {
                html += '<select class="form-control" id="select_addition_id_' + key + '">';
                meal.additions.forEach((addition) => {
                    html += '<option value="' + addition.id + '">' + addition.name + '</option>';
                });
                html += '</select>';
            } else {
                html += '{{trans('admin.not_found')}}';
            }
            html += '</td>' +
                '<td>' +
                '<input type="number" placeholder="{{trans('admin.quantity')}}"' +
                'class="form-control" id="quantity_' + key + '">' +
                '</td>' +
                '<td>' +
                '<button type="button" class="btn btn-primary" onclick="addToCart(' + key + ')">' +
                '{{trans('admin.add_cart')}}' +
                '</button>' +
                '</td>' +
                '</tr>';
            return html;
        }
    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
