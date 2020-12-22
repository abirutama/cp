<section class="section">
    <div class="container">
        <h1 class="title">
            New Investment
        </h1>
        <p class="subtitle">
            Choose a package that suit for <strong>you</strong>
        </p>
        <div class="columns is-variable is-3 is-multiline">
            <?php
            foreach($plan_investment as $key=>$planinvest){ ?>
            <div class="column is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                        <?= $planinvest['tbpi_label']; ?>
                    </h1>
                    <p class="subtitle">
                        <?= $planinvest['tbpi_profit_share']*100; ?>% Daily profit
                    </p>
                    <span><strong><?= $planinvest['tbpi_day_contract']; ?></strong> Days Contract</span><br>
                    <span><strong>USD <?= $planinvest['tbpi_min_deposit']; ?></strong> Minimum Deposit</span>
                    <br><br>
                    <div class="buttons">
                        <button id="open-modal-invest<?= $key; ?>" class="button is-success">Start Invest</button>
                        <button class="button is-outlined">Info</button>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-invest<?= $key; ?>">
                <div class="modal-background"></div>
                <div class="modal-card" style="max-width:480px">
                    <form action="<?= base_url('investment/start_investment/'.$planinvest['tbpi_id']); ?>" method="POST">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Start Investment</p>
                        </header>
                        <section class="modal-card-body">
                            <div class="field">
                                <label class="label">How much you want to invest?</label>
                                <div class="control">
                                    <input name="capital_invest" class="input" type="number" step="1" min="<?= $planinvest['tbpi_min_deposit']; ?>" max="<?= $planinvest['tbpi_max_deposit']; ?>"
                                        value="<?= $planinvest['tbpi_min_deposit']; ?>" placeholder="<?= $planinvest['tbpi_min_deposit']; ?> USD Minimal Deposit">
                                </div>
                            </div>
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button is-success">Continue</button>
                            <div id="close-modal-invest<?= $key; ?>" class="button">Cancel</button>
                        </footer>
                    </form>
                </div>
            </div>
            <script>
            // Modal Deposit
            $("#open-modal-invest<?= $key; ?>").click(function() {
                $("#modal-invest<?= $key; ?>").toggleClass("is-active");
            });
            $("#close-modal-invest<?= $key; ?>").click(function() {
                $("#modal-invest<?= $key; ?>").toggleClass("is-active");
            });
            </script>

            <?php } ?>
        </div>
    </div>
    <div id="my-investment" class="container mt-6">
        <h1 class="title">
            My Investment
        </h1>
        <p class="subtitle">
            All Your Running Investment
        </p>
        <div class="columns is-variable is-3 is-multiline">
        <?php foreach($user_investment as $key=>$userinvest){ ?>
            <div class="column is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                    <?= $userinvest['tbui_label_id']; ?>
                    </h1>
                    <p class="subtitle">
                        <?php 
                        $day_start_to_end = strtotime($userinvest['tbui_end'])-strtotime($userinvest['tbui_start']); 
                        $seconds2 = time()-strtotime($userinvest['tbui_start']); 
                        echo '<span class="tag is-light is-medium">'.floor($seconds2 / 86400) .'/'.ceil($day_start_to_end / 86400).' Days Remaining </span>';
                        ?>
                    </p>
                    <span>Capital: USD <strong><?= $userinvest['tbui_capital']; ?></strong></span><br>
                    <span>Earning: USD <strong><?= floor($seconds2 / 86400) * ($userinvest['tbui_capital']*0.025) ?></strong></span><br>
                    <span>Collected: USD 0/<?= $userinvest['tbui_maxprofit']; ?></span><br>
                    <br>
                    <div class="buttons">
                        <button class="button is-success is-outlined">Withdraw Earning</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    <div id="my-investment" class="container mt-6">
        <h1 class="title">
            My Past Investment
        </h1>
        <p class="subtitle">
            All Your Past Investment
        </p>
        <div class="columns is-variable is-3 is-multiline">
        <?php foreach($user_investment_past as $key=>$userinvestpast){ ?>
            <div class="column  is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                    <?= $userinvestpast['tbui_label_id']; ?>
                    </h1>
                    <?php 
                        $seconds = strtotime($userinvestpast['tbui_end'])-strtotime($userinvestpast['tbui_start']); 
                        $seconds2 = time()-strtotime($userinvestpast['tbui_start']);
                        ?>
                    <span>Capital: USD <strong><?= $userinvestpast['tbui_capital']; ?></strong></span><br>
                    <span>Earning: USD <strong><?= floor($seconds2 / 86400) * ($userinvestpast['tbui_capital']*0.025) ?></strong></span><br>
                    <span>Collected: USD <?= $userinvestpast['tbui_collected']; ?>/<?= $userinvestpast['tbui_maxprofit']; ?></span><br>
                    <br>
                    <div class="buttons">
                        <button class="button is-success is-outlined">Withdraw Capital & Earning</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>