<section class="section">
    <div class="container">
        <h1 class="title">
            My Wallet
        </h1>
        <div class="columns is-variable is-3 is-multiline">
            <div class="column is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                        Primary Wallet
                    </h1>
                    <p class="subtitle">
                        USD <?= $wallet_balance; ?>
                    </p>
                    <div class="buttons">
                        <button id="primary-deposit" class="button is-success">Deposit</button>
                        <button class="button is-outlined">Withdraw</button>
                    </div>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                        Earning Wallet
                    </h1>
                    <p class="subtitle">
                        USD 0.0000
                    </p>
                    <div class="buttons">
                        <button class="button is-outlined">Move to Primary Wallet</button>
                    </div>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="container box">
                    <h1 class="title is-4">
                        Bonus Wallet
                    </h1>
                    <p class="subtitle">
                        USD 0.0000
                    </p>
                    <div class="buttons">
                        <button class="button is-outlined">Move to Primary Wallet</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="deposit-withdraw-act" class="container mt-6">
        <h1 class="title">
            Deposit & Withdraw Activity
        </h1>
        <div class="box">
            <div style="overflow:auto">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>ID</th>
                            <!--<th>Payment Wallet Address</th>-->
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($deposit_history as $key=>$depohistory){ ?>
                        <?php
                            if($depohistory['tbdr_status']>=100){
                                $status_text = 'Complete';
                                $disabled = 'is-hidden';
                            }elseif($depohistory['tbdr_status']>0 && $depohistory['tbdr_status']<=99){
                                $status_text = 'Pending';
                                $disabled = '';
                            }elseif($depohistory['tbdr_status']==0){
                                $status_text = 'Waiting for Payment';
                                $disabled = '';
                            }else{
                                $status_text = 'Cancelled';
                                $disabled = 'is-hidden';
                            }
                        ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $depohistory['tbdr_time_start'] ?></td>
                            <td>USD <?= $depohistory['tbdr_amount_usd'] ?></td>
                            <td><?= $depohistory['tbdr_depoid'] ?></td>
                            <!--<td><?= $depohistory['tbdr_depoto'] ?></td>-->
                            <td><?= $status_text; ?></td>
                            <td><a class="button is-success <?= $disabled; ?>" href="<?= $depohistory['tbdr_statusurl'] ?>"
                                    target="_blank">Pay</a>
                                <a class="button is-outlined <?= $disabled; ?>" href="<?= base_url('wallet/check_deposit/').$depohistory['tbdr_depoid'] ?>"
                                    >Refresh</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-6">
        <h1 class="title">
            Primary Wallet Mutation
        </h1>
        <div class="box">
            <div style="overflow:auto">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <!--<th>Trx ID</th>-->
                            <th>Type</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($wallet_mutation as $key=>$walletmutation){ ?>
                            <?php
                            if($walletmutation['tbpw_type']==0){
                                $mutation_type = 'C';
                                $color_text = 'has-text-success';
                            }elseif($walletmutation['tbpw_type']==-1){
                                $mutation_type = 'D';
                                $color_text = 'has-text-danger';
                            }
                        ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $walletmutation['tbpw_time'] ?></td>
                            <td>USD <?= $walletmutation['tbpw_amount'] ?></td>
                            <td class="<?= $color_text; ?>"><?= $mutation_type; ?></td>
                            <td><?= $walletmutation['tbpw_tnxid'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal" id="modal-wallet">
    <div class="modal-background"></div>
    <div class="modal-card" style="max-width:480px">
        <form action="<?= base_url('wallet/primary_deposit'); ?>" method="POST">
            <header class="modal-card-head">
                <p class="modal-card-title">Wallet Deposit</p>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Amount in USD</label>
                    <div class="control">
                        <input name="depo_amount" class="input" type="number" step="1" min="5" max="1000" value="5"
                            placeholder="5 USD Minimal Deposit">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Select a Coin</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="depo_coin">
                                <option value="LTCT">Litecoin Testnet</option>
                                <option value="DOGE">Doge</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success">Continue</button>
                <div id="close-primary-deposit" class="button">Cancel</button>
            </footer>
        </form>
    </div>
</div>