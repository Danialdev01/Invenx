<?php $location_index = ".."; include('../components/head.php');?>

<body>
    <?php include("../components/user/header.php")?>

    <main>

        <div class="dashboard-grid">

            <?php include("../components/user/nav.php")?>
        
        <!-- Main Content -->
        <div class="main-content">
            <?php include("../components/user/top-bar.php")?>
            
            <!-- Main Dashboard Content -->
            <div class="p-6 max-w-8xl mx-auto">
                
                <?php include('./inventories/components/date_inventory.php')?> 
            </div>
        </div>
    </div>
    
    <!-- Mobile overlay -->
    <div class="overlay"></div>
    
    </main>

    <?php $location_index='..'; include('../components/footer.php')?>
    
</body>
</html>