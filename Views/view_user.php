<?php require 'view_beginco.php'; ?>

<style>
table {
    border-collapse: collapse;
    margin: auto;
}

td, th {
    border: 1px solid black;
    width: 220px;
    height: 30px;
}
</style>

<main>
    <h1 style="color: #000000; text-align: center;">Bonjour <?php echo htmlspecialchars($welcome); ?></h1>

    <section class="suivi" id="suivi">
        <div class="suivi-bt">
            <h3>Demandes</h3>
            <a href="?controller=user&action=new_request"><button class="bt_user">Nouvelle demande</button></a>
        </div>
        <table>

            <tr class="suivi-title">
                <th>Type</th>
                <th>Date</th>
                <th>Référence</th>
                <th>Statut</th>
            </tr>

            <?php if (!empty($visaRequests)) : ?>
                <?php foreach ($visaRequests as $request) : ?>
                    <tr class="suivi-info">
                        <td><?php echo htmlspecialchars($request['type']); ?></td>
                        <td><?php echo htmlspecialchars($request['date']); ?></td>
                        <td><?php echo htmlspecialchars($request['reference']); ?></td>
                        <td><?php echo htmlspecialchars($request['statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="suivi-info">
                    <td colspan="5">Aucune demande.</td>
                </tr>
            <?php endif; ?>

        </table>
    </section>

</main>

<?php require 'view_end.php'; ?>
