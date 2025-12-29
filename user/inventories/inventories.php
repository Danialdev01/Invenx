<?php 
$location_index = "../.."; 
include('../../components/head.php');

?>

<body>
    <?php include("../../components/user/header.php")?>

    <main>
        <div class="dashboard-grid">
            <?php include("../../components/user/nav.php")?>
            
            <!-- Main Content -->
            <div class="main-content">
                <?php include("../../components/user/top-bar.php")?>
                
                <!-- Main Dashboard Content -->
                <div class="p-6">
                    <?php include('./components/date_inventory.php'); ?>
                </div>
            </div>
        </div>

        <!-- Mobile overlay -->
        <div class="overlay"></div>
    </main>

    <script>
        // Initialize DataTable
        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#default-table", {
                searchable: true,
                perPageSelect: true,
                perPage: 10
            });
        }

        // Fungsi untuk buang bookmark
        function removeBookmark(recipeId) {
            if (confirm('Adakah anda pasti ingin membuang resipi ini dari bookmark?')) {
                const formData = new FormData();
                formData.append('recipe_id', recipeId);
                formData.append('remove_bookmark', 'true');
                formData.append('token', '<?php echo $token ?? ""; ?>');

                fetch('<?php echo $location_index; ?>/backend/recipe.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Resipi berjaya dikeluarkan dari bookmark.');
                        location.reload();
                    } else {
                        alert('Gagal mengeluarkan resipi: ' + (data.error || 'Sila cuba lagi.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ralat berlaku ketika mengeluarkan resipi.');
                });
            }
        }
    </script>

    <?php $location_index='../..'; include('../../components/footer.php')?>
</body>
</html>