<!--  Modal content for the above example -->
<div class="modal fade credit_modal" data-backdrop="static" tabindex="-1" role="dialog"
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
                                    <form role="form" id="credit-form">

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label"
                                                       for="amount">{{trans('admin.amount')}}</label>
                                                <input required type="number" id="amount" name="amount"
                                                       class="form-control"
                                                       placeholder="{{trans('admin.amount')}}">
                                            </div> <!-- form-group -->

                                            <div class="form-group col-sm-12">
                                                <label class="control-label"
                                                       for="reason">{{trans('admin.reason')}}</label>
                                                <textarea id="reason" name="reason"
                                                       class="form-control"
                                                          placeholder="{{trans('admin.reason')}}"></textarea>
                                            </div> <!-- form-group -->
                                        </div>

                                        <input type="hidden" name="type" />

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
