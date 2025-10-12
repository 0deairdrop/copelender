<?php 
$arAllTransactions = $rs['arTransactions']['arTransactions'];
?>
<div class="tab-pane fade show active" id="transaction-history-content" role="tabpanel" aria-labelledby="transaction-history-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arAllTransactions) > 0)
        {    
            foreach ($arAllTransactions as $allTransactions)
            {
                $debitCredit = $allTransactions['debit_credit'];
                $class = 'decrement';
                $sign  = '- NGN';
                $arrow  = 'down';
                if ($debitCredit)
                {
                    $class = 'increment';
                    $sign  = '+ NGN';
                    $arrow  = 'up';
                }
        ?>      
                <div class="transaction-type__single <?= $class ?>">
                        <div class="transaction-type__single__icon">
                            <i class="uil uil-arrow-<?= $arrow ?>"></i>
                        </div>
                        <div class="transaction-type__single__content">
                                <h4 class="transaction-type__single__content__title"><?=  $allTransactions['reference'].' ('.$allTransactions['name'] .')' ?></h4>
                                <p class="transaction-type__single__content__subtitle"><?= $allTransactions['tdate'] ?></p>
                        </div>
                        <div class="transaction-type__single__rate">
                            <span class="<?= $class ?>"><?= $sign.' '. $allTransactions['amount'] ?></span>
                        </div>
                </div>   
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>