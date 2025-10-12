
<?php 
$arCredits = $rs['arTransactions']['arCredits'];
$class = 'increment';
$icon = 'uil uil-arrow-up';
if ($isAdmin)
{
    $class = 'decrement';
    $icon = 'uil uil-arrow-down';
}
?>
<div class="tab-pane fade" id="transaction-credits-content" role="tabpanel" aria-labelledby="transaction-credits-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arCredits) > 0)
        {    
            foreach ($arCredits as $creditTrasactgions)
            {
        ?>
           
                <div class="transaction-type__single <?= $class?>">
                    <div class="transaction-type__single__icon">
                        <i class="<?= $icon?>"></i>
                    </div>
                    <div class="transaction-type__single__content">
                            <h4 class="transaction-type__single__content__title"><?= ucwords($creditTrasactgions['name']) ?></h4>
                            <p class="transaction-type__single__content__subtitle"><?= $creditTrasactgions['tdate'] ?></p>
                    </div>
                    <div class="transaction-type__single__rate">
                        <span class="<?= $class?>"> <?= $creditTrasactgions['amount'] ?></span>
                    </div>
                </div>   
           
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>