
<?php 

    // get date 
    if(isset($_GET['date'])) {
        $set_date = $_GET['date'];
    }
    else{
        $set_date = date('Y-m-d');
    }

    // check if date is valid
    if (!DateTime::createFromFormat('Y-m-d', $set_date)) {
        $set_date = date('Y-m-d');
    }

    $set_date_display = date("l d/m/Y", strtotime($set_date));

    // date('l n/j/Y')
?>


<div class="p-6 border-b border-gray-200">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800"><?php echo $set_date_display;?></h2>
            <p class="text-gray-600 text-sm mt-1">
            </p>
        </div>
        <!-- <div class="text-sm text-gray-500"> -->
            <!-- <i class="fas fa-info-circle mr-1"></i> -->
            <!-- All  -->
        <!-- </div> -->
    </div>
</div>

<table id="today-inventory-table">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    Name
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th data-type="date" data-format="YYYY/DD/MM">
                <span class="flex items-center">
                    Unit
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Opening Stock
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Received from CK / Production
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Closing Stock
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Menu Item Sold
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Notes
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Action
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 

            //TODO buat check if item ada dalam date ni tapi inactive sekarang
            $items_inventory_sql = $connect->prepare("SELECT * FROM items WHERE status_item = 1");
                    
            $items_inventory_sql->execute();
                    
            while($items_inventory = $items_inventory_sql->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr>
                    
                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal">
                        <?php echo htmlspecialchars($items_inventory['name_item'])?>
                    </td>
                    <td><?php echo htmlspecialchars($items_inventory['unit_item'])?></td>

                    <?php 
                        
                        // if there is today stock entry for this item, fetch it
                        $today_date = date("Y-m-d");
                        $stock_entry_sql = $connect->prepare("SELECT * FROM stocks WHERE id_item = :id_item AND created_date_stock = :created_date_stock AND status_stock = 1");
                        $stock_entry_sql->execute([
                            ':id_item' => $items_inventory['id_item'],
                            ':created_date_stock' => $set_date
                        ]);
                        $stock_entry = $stock_entry_sql->fetch(PDO::FETCH_ASSOC);

                        if($stock_entry){
                            $opening_stock = $stock_entry['opening_stock'];
                            $received_stock = $stock_entry['received_stock'];
                            $closing_stock = $stock_entry['closing_stock'];
                            $menu_item_sold = $stock_entry['sold_stock'];
                            $notes_stock = $stock_entry['notes_stock'];
                            $form_type = "edit";
                        }
                        else{
                            // get prev's date
                            $previous_day = date('Y-m-d', strtotime($set_date . ' -1 day'));

                            $last_stock_entry_sql = $connect->prepare("SELECT * FROM stocks WHERE id_item = :id_item AND created_date_stock = :created_date_stock AND status_stock = 1 ORDER BY created_date_stock DESC LIMIT 1");
                            $last_stock_entry_sql->execute([
                                ':id_item' => $items_inventory['id_item'],
                                ':created_date_stock' => $previous_day
                            ]);
                            $last_stock_entry = $last_stock_entry_sql->fetch(PDO::FETCH_ASSOC);
                            $opening_stock = $last_stock_entry ? $last_stock_entry['closing_stock'] : 0;
                            $received_stock = "Not Set";
                            $closing_stock = "Not Set";
                            $menu_item_sold = "Not Set";
                            $notes_stock = "None";
                            $form_type = "create";
                        }

                    ?>
                    <td><?php echo $opening_stock?></td>

                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal"><?php echo $received_stock?></td>

                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal"><?php echo $closing_stock?></td>

                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal"><?php echo $menu_item_sold?></td>

                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal"><?php echo $notes_stock?></td>
                    <td class="font-medium text-heading whitespace-nowrap" data-modal-target="inventory-<?php echo $items_inventory['id_item']?>-modal" data-modal-toggle="inventory-<?php echo $items_inventory['id_item']?>-modal">
                        <button type="button" class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                            <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                            Edit
                        </button>
                    </td>
                    <div id="inventory-<?php echo $items_inventory['id_item']?>-modal" style="z-index: 100000;" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                    <h3 class="text-lg font-medium text-heading">
                                        <?php echo htmlspecialchars($items_inventory['name_item']);?>
                                    </h3>
                                    <button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="inventory-<?php echo $items_inventory['id_item']?>-modal">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="<?php echo $location_index?>/backend/inventory.php" method="POST">
                                    <input type="hidden" name="date_stock" value="<?php echo $set_date?>">
                                    <input type="hidden" name="id_item" value="<?php echo $items_inventory['id_item']?>">

                                    <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="opening_stock" class="block mb-2.5 text-sm font-medium text-heading">Opening Stock</label>
                                            <input type="number" name="opening_stock" id="opening_stock" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" value="<?php echo $opening_stock?>" required="">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="unit_item" class="block mb-2.5 text-sm font-medium text-heading">Unit</label>
                                            <select disabled id="unit_item" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body">
                                                <option value="<?php echo $items_inventory['unit_item']?>" selected=""><?php echo htmlspecialchars($items_inventory['unit_item']);?></option>
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="received_stock" class="block mb-2.5 text-sm font-medium text-heading">Received From CK / Production</label>
                                            <input type="number" name="received_stock" id="received_stock" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" value="<?php echo $received_stock?>" required="">
                                        </div>
                                        <!-- <div class="col-span-2">
                                            <label for="closing_stock" class="block mb-2.5 text-sm font-medium text-heading">Closing Stock</label>
                                            <input type="number" name="closing_stock" id="closing_stock" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" value="<?php echo $closing_stock?>" required="">
                                        </div> -->
                                        <div class="col-span-2">
                                            <label for="sold_stock" class="block mb-2.5 text-sm font-medium text-heading">Menu Item Sold</label>
                                            <input type="number" name="sold_stock" id="sold_stock" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" value="<?php echo $menu_item_sold?>" required="">
                                        </div>
                                        <div class="col-span-2">
                                            <label for="notes_stock" class="block mb-2.5 text-sm font-medium text-heading">Notes</label>
                                            <textarea id="notes_stock" name="notes_stock" rows="4" class="block bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body" placeholder="Write item notes here"><?php echo $notes_stock?></textarea>                    
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                        <button name="<?php echo $form_type?>_stock" type="submit" class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                            <!-- <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg> -->
                                            <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>

                                            <?php echo ucfirst($form_type)?> Stock Inventory
                                        </button>
                                        <button data-modal-hide="crud-modal" type="button" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </tr>
            <?php 
            }
        ?>
        
    </tbody>
</table>

<script>

    if (document.getElementById("today-inventory-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#today-inventory-table", {
            searchable: false,
            perPageSelect: false
        });
    }

</script>