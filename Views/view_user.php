<?php require 'view_beginco.php'; ?>

<style>
table { 
    border-collapse : collapse;
    margin : auto;
}

td,th {
border : 1px solid black;
width : 220px;
height : 30px;
}

</style>

<main>
    <h1 style="color: #000000; text-align: center;">Bonjour<?php if (!empty($welcome)) : ?> <?php echo htmlspecialchars($welcome); ?><?php endif; ?></h1>

    <section class="suivi" id="suivi">
        <div class="suivi-bt">
            <h3>Demandes</h3>
            <button>Nouvelles demandes</button>
        </div>
        <table>

            <tr class="suivi-title">
                <th>Type</th>
                <th>Date</th>
                <th>Références</th>
                <th>Statut</th>
            </tr>

            <tr class="suivi-info">
                <td>Visa</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>     

    </section>

</main>

