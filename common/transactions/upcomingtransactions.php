
<?php 
$arTransactions = $rs['arTransactions']['arUpcomingTransactions'];
?>
<div class="tab-pane fade" id="transaction-upcoming-content" role="tabpanel" aria-labelledby="transaction-upcoming-tab">
    <div class="transaction-content">
        <div class="transaction-type">
        <?php if (count($arTransactions) > 0)
        {    
            foreach ($arTransactions as $upcomingTransactions)
            {
        ?>
           
                <div class="transaction-type__single ">
                    <div class="transaction-type__single__icon">
                        <i class="uil uil-arrow-down"></i>
                    </div>
                    <div class="transaction-type__single__content">
                            <h4 class="transaction-type__single__content__title"><?= ucwords($upcomingTransactions['name']) ?></h4>
                            <p class="transaction-type__single__content__subtitle"><?= $upcomingTransactions['tdate'] ?></p>
                    </div>
                    <div class="transaction-type__single__rate">
                        <span class=""> <?= $upcomingTransactions['amount'] ?></span>
                    </div>
                </div>   
           
        <?php 
            }
        }
        ?>
         </div>
    </div>
</div>