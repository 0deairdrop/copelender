<?php  
$arPendingLoans = $rs['arLoanData']['arPendingLoans']
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
                <div class="swiper-slide">
                    <?php if (count($arPendingLoans) > 0)
                        {
                            foreach ($arPendingLoans as $pendinLoans)
                            {
                        ?>
                            <div class="geex-content__review__single">
                                <div class="geex-content__review__single__header">
                                    <div class="geex-content__review__single__header__img" 
                                        style="text-align: center; font-size: 40px; color: var(--bs-primary);">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="geex-content__review__single__header__text">
                                        <h4 class="geex-content__review__single__header__title"><?= $pendinLoans['user'] ?></h4>
                                        <p class="geex-content__review__single__header__subtitle"><?= $pendinLoans['cdate'] ?></p>
                                        <p class="geex-content__review__single__header__subtitle">Amount : <?= $pendinLoans['amount'] ?></p>
                                        <p class="geex-content__review__single__header__subtitle">Repayment Type : <?= $pendinLoans['repayment_type'] ?></p>
                                    </div>
                                </div>
                                <div class="geex-content__review__single__content">
                                    <p class="geex-content__review__single__content__text"><?= $pendinLoans['purpose'] ?></p>
                                </div>
                                <div class="geex-content__review__single__bottom">
                                    <a href="#" class="geex-content__review__single__btn danger-color">Reject</a>
                                    <a href="#" class="geex-content__review__single__btn success-color">Approve</a>
                                </div>
                            </div>
                        <?php 
                            } 
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>