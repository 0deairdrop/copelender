<?php  
$arApprovedLoans = $rs['arLoanData']['arApprovedLoans'];
$arActivationRequest = $rs['arActivationRequest'];
?>
<div class="geex-content__widget">
    <div class="geex-content__widget__single">
        <div class="geex-content__widget__single__header">
            <h4 class="geex-content__widget__single__title">Recent Activation Request</h4>
            <p class="geex-content__widget__single__subtitle">Quick Account Activation</p>
        </div>
        <div class="geex-content__widget__single__content">
            <?php if (count($arActivationRequest) > 0) 
            {
                foreach ($arActivationRequest as $activattionRequest)
                {
            ?>
                <div class="geex-content__widget__single__cta mb-30">
                    <div class="geex-content__review__single__header__img" 
                        style="text-align: center; font-size: 40px; color: var(--bs-primary);">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="geex-content__widget__single__cta__text">
                        <h4 class="geex-content__widget__single__cta__title"><?= $activattionRequest['name']?></h4>
                        <a href="#" class="geex-content__widget__single__cta__link"><?= $activattionRequest['reference']?></a>
                    </div>
                   <button type="button" class="geex-btn geex-btn--success" onclick="activateUserProfile('<?= $activattionRequest['id'] ?>')">Activate</button>
                </div>
            <?php 
                    }
                }
            ?>
        </div>
    </div>

    <div class="geex-content__widget__single">
        <div class="geex-content__widget__single__header">
            <h4 class="geex-content__widget__single__title">Recent Approved Loans</h4>
            <p class="geex-content__widget__single__subtitle">Loans Application Approved</p>
        </div>
        <div class="geex-content__widget__single__content">
            <?php if (count($arApprovedLoans) > 0) 
            {
                foreach ($arApprovedLoans as $approvedLoans)
                {
            ?>
            <div class="geex-content__widget__single__timeline">
                <div class="geex-content__widget__single__timeline__content">
                <h4 class="geex-content__widget__single__timeline__content__title"><?= $approvedLoans['user']?></h4>
                <p class="geex-content__widget__single__timeline__content__subtitle">Date: <?= $approvedLoans['cdate']?></p>
                <p class="geex-content__widget__single__timeline__content__subtitle">Amount: <?= $approvedLoans['amount']?></p>
                <p class="geex-content__widget__single__timeline__content__subtitle">Frequency: <?= ucwords($approvedLoans['repayment_type'])?></p>
                </div>
            </div>
        <?php 
                }
            }
        ?>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.activate-btn', function() {
    const id = $(this).data('id');
    activateUserProfile(id);
});

function activateUserProfile(id) {
    // Confirmation alert
    Swal.fire({
        title: 'Activate Profile?',
        text: "Are you sure you want to activate this user profile?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, activate',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $('body').append('<div id="block-overlay" class="geex-overlay">Processing...</div>');

            $.ajax({
                url: 'actions',
                type: 'POST',
                data: {
                    action: 'activate',
                    id: id,
                    moduleId: '<?= DEF_MODULE_ID_USER ?>'
                },
                dataType: 'json',
                success: function(res) {
                    $('#block-overlay').remove();
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Activated!',
                            text: res.message || 'Profile successfully activated.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Error', res.message || 'Activation failed.', 'error');
                    }
                },
                error: function() {
                    $('#block-overlay').remove();
                    Swal.fire('Error', 'Request failed. Please try again.', 'error');
                }
            });
        }
    });
}
</script>