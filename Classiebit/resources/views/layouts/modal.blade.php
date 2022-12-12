<style>
    .swal2-popup,
    .swal2-modal,
    .swal2-icon-success,
    .swal2-show {
        font-size: 15px;
    }

    .circle-loader:before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 48px;
        height: 48px;
        margin-left: -24px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        border: 2px solid #d0d6e9;
        border-top-color: #118cf1;
        -moz-animation: modalspinner .6s linear infinite;
        -webkit-animation: modalspinner .6s linear infinite;
        animation: modalspinner .6s linear infinite;
    }

    @-moz-keyframes modalspinner {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes modalspinner {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
    .modal-content button.close {
    right: 13px;}
    .modal-title {
    
    font-family: 'Din bold';
}
@media print{
    .circle-loader{display: none !important;}
}
</style>
<?php if(is_rtl()):?>
<style>
.modal-content button.close {
    left: auto;
    right: 13px;}
</style>
<?php else:?>

    <style>
.modal-content button.close {
    left: 13px;
    right: auto;}
</style>
<?php endif;?>

<!-- Modal -->
<div class="modal" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModal" aria-hidden="true">
    <div class="modal-dialog mini-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <span class="modal-title" id="ajaxModalTitle" data-title=""></span>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="ajaxModalContent">
            <div class="circle-loader"></div>
            </div>
  
            </div>
        </div>
    </div>
</div>

