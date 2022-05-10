<!-- delete Modal -->
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Cancellation Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{translate('Are you sure to cancel this order')}}</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a href="" id="delete-link" class="btn btn-primary mt-2">{{translate('Cancel Order')}}</a>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
