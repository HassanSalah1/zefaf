<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">

            <table id="datatable" class="table table-bordered">
                <thead>
                <tr>
                    @foreach($debatable_names as $column)

                        <th>
                            {{$column}}
                        </th>
                    @endforeach
                </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>