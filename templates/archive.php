<?php
    function output_archive_user_profile() { ?>
        <article id='archive page'>
            <section id='archive_header'>
                <img class="user_pfp" src="imagens/randomImage.jpg">
                <h4>Archive</h4>
                <p>(Sold Items)</p>
            </section>
        
    <?php }
?>

<?php
    function output_archive_user_products($db, $products) { ?>
        <section id='archive_products'>
        <?php
        foreach ($products as $product) { ?>
            
            output_single
            <article class='static_offer'>

            </article>
         <?php }
        ?>
        </section>

    </article>
    <?php }
?>