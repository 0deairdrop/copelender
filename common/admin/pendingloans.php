<?php  
$arPendingLoans = $rs['arLoanData']['arPendingLoans'];
?>
<div class="geex-content__section geex-content__section--transparent geex-content__review" style="margin-bottom:20px">
    <div class="geex-content__section__header">
        <div class="geex-content__section__header__title-part">
            <h4 class="geex-content__section__header__title">Recent Loans Application</h4>
            <p class="geex-content__section__header__subtitle">Quick Approval</p>
        </div>
        <div class="geex-content__section__header__content-part">
            <div class="geex-content__section__header__btn geex-content__section__header__swiper-btn">
                <div class="swiper-btn swiper-btn-prev">
                    <i class="uil-arrow-left"></i>
                </div>
                <div class="swiper-btn swiper-btn-next">
                    <i class="uil-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="geex-content__section__content">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if (count($arPendingLoans) > 0):
                    foreach ($arPendingLoans as $pendinLoans): ?>
                        <div class="swiper-slide">
                            <div class="geex-content__review__single">
                                <div class="geex-content__review__single__header">
                                    <div class="geex-content__review__single__header__img" 
                                        style="text-align: center; font-size: 40px; color: var(--bs-primary);">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="geex-content__review__single__header__text">
                                        <h4 class="geex-content__review__single__header__title"><?= $pendinLoans['user'] ?></h4>
                                        <p class="geex-content__review__single__header__subtitle"><?= $pendinLoans['cdate'] ?></p>
                                        <p class="geex-content__review__single__header__subtitle">Amount: <?= $pendinLoans['amount'] ?></p>
                                        <p class="geex-content__review__single__header__subtitle">Repayment Type: <?= $pendinLoans['repayment_type'] ?></p>
                                    </div>
                                </div>
                                <div class="geex-content__review__single__content">
                                    <p class="geex-content__review__single__content__text"><?= $pendinLoans['purpose'] ?></p>
                                </div>
                                <div class="geex-content__review__single__bottom">
                                    <a href="#" class="geex-content__review__single__btn danger-color reject-btn" data-id="<?= $pendinLoans['id'] ?>">Reject</a>
                                    <a href="#" class="geex-content__review__single__btn success-color approve-btn" data-id="<?= $pendinLoans['id'] ?>">Approve</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; 
                endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function handleApproval(id, type) {
    const actionText = type === 'approve' ? 'approve' : 'reject';
    const actionColor = type === 'approve' ? '#28a745' : '#d33';
    const successMsg = type === 'approve' ? 'Loan Approved!' : 'Loan Rejected!';

    Swal.fire({
        title: `${actionText} this Loan?`,
        text: `Are you sure you want to ${actionText.toLowerCase()} this loan?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText}`,
        cancelButtonText: 'Cancel',
        confirmButtonColor: actionColor,
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            $("body").append(`
                <div id="block-overlay" 
                     style="position:fixed; top:0; left:0; width:100%; height:100%;
                            background:rgba(0,0,0,0.5); z-index:9999; display:flex;
                            align-items:center; justify-content:center; color:#fff;
                            font-size:20px; font-weight:bold;">
                    Processing...
                </div>
            `);

            $.ajax({
                url: 'actions',
                type: 'POST',
                data: {
                    action: type,
                    id: id,
                    moduleId: '<?= DEF_MODULE_ID_LOAN_APPLICATION ?>'
                },
                dataType: 'json',
                success: function(res) {
                    $('#block-overlay').remove();
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: successMsg,
                            text: res.message || successMsg,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Failed', res.message || `${actionText} failed.`, 'error');
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

$(document).on('click', '.approve-btn', function(e) {
    e.preventDefault();
    handleApproval($(this).data('id'), 'approve');
});

$(document).on('click', '.reject-btn', function(e) {
    e.preventDefault();
    handleApproval($(this).data('id'), 'reject');
});

// Initialize Swiper
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3, // number of visible cards
    spaceBetween: 20,
    navigation: {
        nextEl: '.swiper-btn-next',
        prevEl: '.swiper-btn-prev',
    },
    loop: false,
    breakpoints: {
        320: { slidesPerView: 1, spaceBetween: 10 },
        640: { slidesPerView: 2, spaceBetween: 15 },
        1024: { slidesPerView: 3, spaceBetween: 20 }
    }
});
</script>
