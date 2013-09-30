<?php require_once('job.php'); ?>
<html>
    <head>
        <title>My Board</title>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <script type="text/javascript">

        </script>
    </head>
    <body>
        <div id="page" align="center">
            <div class="container" align="left">
                <div id="cards">
                    <h1>My earnings:</h1>
                    <div id="cm_earnings" class="c240 card fleft">
                        <h2>This month earnings:</h2>
                        <div align="center" class="big"><?php echo $cm_earnings_rub?> RUB</div>
                        <div align="center" class="goal">Goal: 140000 RUB</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($cm_earnings_rub/1400) >= 100) { echo "100%"; }else{ echo round($cm_earnings_rub / 1400);}?>%;"><?php if (round($cm_earnings_rub / 1400) > 15){ echo round($cm_earnings_rub / 1400).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="lw_earnings" class="c240 card fleft">
                        <h2>Last week earnings:</h2>
                        <div align="center" class="big"><?php echo $lw_earnings_rub?> RUB</div>
                        <div align="center" class="goal">Goal: 35000 RUB</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($lw_earnings_rub/350) >= 100) { echo "100%"; }else{ echo round($lw_earnings_rub / 350);}?>%;"><?php if (round($lw_earnings_rub / 350) > 15){ echo round($lw_earnings_rub / 350).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="cw_earnings" class="c240 card fleft">
                        <h2>This week earnings:</h2>
                        <div align="center" class="big"><?php echo $cw_earnings_rub?> RUB</div>
                        <div align="center" class="goal">Goal: 35000 RUB</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($cw_earnings_rub/350) >= 100) { echo "100%"; }else{ echo round($cw_earnings_rub / 350);}?>%;"><?php if (round($cw_earnings_rub / 350) > 15){ echo round($cw_earnings_rub / 350).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="t_earnings" class="c240 card fleft">
                        <h2>Today's earnings:</h2>
                        <div align="center" class="big"><?php echo $t_earnings_rub?> RUB</div>
                        <div align="center" class="goal">Goal: 7000 RUB</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($t_earnings_rub/70) >= 100) { echo "100%"; }else{ echo round($t_earnings_rub / 70);}?>%;"><?php if (round($t_earnings_rub / 70) > 15){ echo round($t_earnings_rub / 70).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <h1>Worked hours:</h1>
                    <div id="cm_earnings" class="c240 card fleft">
                        <h2>This month hours:</h2>
                        <div align="center" class="big"><?php echo round($cm_hours, 1)?> hours</div>
                        <div align="center" class="goal">Goal: 280 hours</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($cm_hours/3.2) >= 100) { echo "100%"; }else{ echo round($cm_hours / 3.2);}?>%;"><?php if (round($cm_hours / 3.2) > 15){ echo round($cm_hours / 3.2).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="lw_earnings" class="c240 card fleft">
                        <h2>Last week hours:</h2>
                        <div align="center" class="big"><?php echo round($lw_hours, 1)?> hours</div>
                        <div align="center" class="goal">Goal: 70 hours</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($lw_hours/0.7) >= 100) { echo "100%"; }else{ echo round($lw_hours / 0.7);}?>%;"><?php if (round($lw_hours / 0.7) > 15){ echo round($lw_hours / 0.7).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="cw_earnings" class="c240 card fleft">
                        <h2>This week hours:</h2>
                        <div align="center" class="big"><?php echo round($cw_hours, 1)?> hours</div>
                        <div align="center" class="goal">Goal: 70 hours</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($cw_hours/0.7) >= 100) { echo "100%"; }else{ echo round($cw_hours / 0.7);}?>%;"><?php if (round($cw_hours / 0.7) > 15){ echo round($cw_hours / 0.7).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div id="t_earnings" class="c240 card fleft">
                        <h2>Today's hours:</h2>
                        <div align="center" class="big"><?php echo round($t_hours, 1)?> hours</div>
                        <div align="center" class="goal">Goal: 12 hours</div>
                        <div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($t_hours/0.12) >= 100) { echo "100%"; }else{ echo round(($t_hours) / 0.12);}?>%;"><?php if (round(($t_hours) / 0.12) > 15){ echo round(($t_hours) / 0.12).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <h2>Other KPI-s</h2>
                    <div id="t_earnings" class="c240 card fleft">
                        <h2>Hours left:</h2>
                        <div align="center" class="big"><?php echo round($hours_left, 1)?> hours</div>
                        <div align="center" class="goal">Total: 168h</div>
                        <!--<div class="progress">
                            <div class="external">
                                <div class="internal" style="width: <?php if (round($t_hours/0.1) >= 100) { echo "100%"; }else{ echo round(($t_hours) / 0.1);}?>%;"><?php if (round(($t_hours) / 0.1) > 15){ echo round(($t_hours) / 0.1).'%'; }else{?>&nbsp;<?php }?></div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>