
<?php 
$arDebits = $rs['arTransactions']['arDebits'];
?>
<div class="tab-pane fade" id="transaction-debits-content" role="tabpanel" aria-labelledby="transaction-debits-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arDebits) > 0)
        {    
            foreach ($arDebits as $debitTransactions)
            {
        ?>
           
                <div class="transaction-type__single decrement">
                    <div class="transaction-type__single__icon">
                        <i class="uil uil-arrow-down"></i>
                    </div>
                    <div class="transaction-type__single__content">
                            <h4 class="transaction-type__single__content__title"><?= ucwords($debitTransactions['name']) ?></h4>
                            <p class="transaction-type__single__content__subtitle"><?= $debitTransactions['tdate'] ?></p>
                    </div>
                    <div class="transaction-type__single__rate">
                        <span class="decrement"> <?= $debitTransactions['amount'] ?></span>
                    </div>
                </div>   
           
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>