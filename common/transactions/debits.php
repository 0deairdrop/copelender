
<?php 
$arDebits = $rs['arTransactions']['arDebits'];

$class = 'decrement';
$icon = 'uil uil-arrow-down';
if ($isAdmin)
{
    $class = 'increment';
    $icon = 'uil uil-arrow-up';
}
?>
<div class="tab-pane fade" id="transaction-debits-content" role="tabpanel" aria-labelledby="transaction-debits-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arDebits) > 0)
        {    
            foreach ($arDebits as $debitTransactions)
            {
        ?>
           
                <div class="transaction-type__single <?= $class ?>">
                    <div class="transaction-type__single__icon">
                        <i class="<?= $icon ?>"></i>
                    </div>
                    <div class="transaction-type__single__content">
                            <h4 class="transaction-type__single__content__title"><?= ucwords($debitTransactions['name']) ?></h4>
                            <p class="transaction-type__single__content__subtitle"><?= $debitTransactions['tdate'] ?></p>
                    </div>
                    <div class="transaction-type__single__rate">
                        <span class="<?= $class ?>"> <?= $debitTransactions['amount'] ?></span>
                    </div>
                </div>   
           
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>