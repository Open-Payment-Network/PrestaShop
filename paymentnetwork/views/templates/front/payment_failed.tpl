{extends "$layout"}

{block name="content"}
<section id="main">
    <section id="content" class="page-content card card-block">
        <h2>Payment Declined - {$transaction_id}</h2>
        {$response_message}
        <p class="warning">
            {l s='Unfortunately payment has failed for your order. Please recomplete the checkout process.'}
        </p>
    </section>
</section>
{/block}
