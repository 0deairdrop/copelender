
<?php 
$arCredits = $rs['arTransactions']['arCredits'];
?>
<div class="tab-pane fade" id="transaction-credits-content" role="tabpanel" aria-labelledby="transaction-credits-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arCredits) > 0)
        {    
            foreach ($arCredits as $creditTrasactgions)
            {
        ?>
           
                <div class="transaction-type__single increment">
                    <div class="transaction-type__single__icon">
                        <i class="uil uil-arrow-up"></i>
                    </div>
                    <div class="transaction-type__single__content">
                            <h4 class="transaction-type__single__content__title"><?= ucwords($creditTrasactgions['name']) ?></h4>
                            <p class="transaction-type__single__content__subtitle"><?= $creditTrasactgions['tdate'] ?></p>
                    </div>
                    <div class="transaction-type__single__rate">
                        <span class="increment"> <?= $creditTrasactgions['amount'] ?></span>
                    </div>
                </div>   
           
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>