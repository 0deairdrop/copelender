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
                    <div class="geex-content__widget__single__cta__status">
                        <a href="#" class="geex-content__widget__single__cta__btn success-bg">Activate</a>
                    </div>
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