<?php  
$ar = $rs['arProgress'];
?>
<div class="geex-content__widget">
<div class="geex-content__widget__single">
    <div class="geex-content__widget__single__header">
        <h4 class="geex-content__widget__single__title">Ongoing Loans</h4>
        <p class="geex-content__widget__single__subtitle">All Loans</p>
    </div>
    <div class="geex-content__widget__single__content"></div>
    <?php if (count($ar) > 0) 
    { 
  
        foreach ($ar as $r)
        {
            $percentage = $r['percentagePaid'];
            if ($percentage > 85)
            {
                $class = 'success';
            }
            elseif ($percentage > 60)
            {
                $class = 'info';
            }
            else
            {
                $class = 'warning';
            }
    ?>
            <div class="geex-content__widget__single__progress <?= $class ?> mb-30">
                <div class="geex-content__widget__single__progress__icon">
                    <i class="uil uil-info-circle"></i>
                </div>
                <div class="geex-content__widget__single__progress__text">
                    <h4 class="geex-content__widget__single__progress__title"><?= strtoupper($r['name']) ?></h4>
                    <div class="geex-content__widget__single__progressbar">
                        <div class="geex-content__widget__single__progressbar__inner" style="width: <?php echo $percentage; ?>%;"></div>

                    </div>
                    <p class="geex-content__widget__single__progress__subtitle"><span>NGN <?= $r['paid'] ?> paid</span> / from <?= $r['left'] ?></p>
                </div>
            </div>
    <?php 
        }
    } 
    ?>
    </div>
</div>
</div>