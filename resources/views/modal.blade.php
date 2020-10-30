<div class="form-group">
    <button type="button" class="btn btn-outline-primary show-modal" data-toggle="modal" data-target="#notification-modal<?php if(isset($id)) echo '-' . $id;?>" style="display:none;"></button>
</div>

<div class="modal fade <?php if(isset($class)) echo $class;?>" tabindex="-1" id="notification-modal<?php if(isset($id)) echo '-' . $id;?>" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:24px;">@if(isset($title)) {{$title}} @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="status">
                    <div class="success-status" style="display:none;">
                        <i class="fa fa-check-square-o" style="font-size:48px;color:#38c172;display:block;text-align:center;"></i>
                        <span class="text-success" style="font-size:24px;display:block;text-align:center;font-weight:bold;"> Success </span>
                    </div>
                    <div class="error-status" style="display:none;">
                        <i class="fa fa-minus-square" style="font-size:48px;color:red;display:block;text-align:center;"></i>
                        <span class="text-danger" style="font-size:24px;display:block;text-align:center;font-weight:bold;"> Failed </span>
                    </div>
                    @if(isset($checkDelete) && $checkDelete)
                        <div class="delete-object text-center">
                            <h3>Are You Sure?</h3>
                            <p style="margin: 30px 0px;">
                                Do you really want to delete @if(isset($object)) {{$object}} @endif "<span id="object-name">{{$name}}</span>" ? This <br>
                                process cannot be undo.
                            </p>
                            <input type="hidden" class="object-id" value="<?php if(isset($id)) echo $id;?>"/>
                            <button type="button" class="btn btn-secondary" style="padding:7px 25px; font-size: 16px;" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="submit-delete" style="font-size: 17px;">Delete</button>
                        </div>
                    @endif
                </div>
                <p class="message" style="font-size:16px;display:block;text-align:center;margin:20px 0;"></p>
            </div>
        </div>
    </div>
</div>