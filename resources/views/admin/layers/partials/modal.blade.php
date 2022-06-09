<!--  Modal content for the above example -->
<div class="modal fade general_modal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" id="general-form">
                                        @yield('form_inputs')
                                        <div class="form-group btn-left">
                                            <button type="submit"
                                                    class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                                {{trans('admin.save')}}
                                            </button>
                                        </div>

                                    </form>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div>
                    </div><!-- end col -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
