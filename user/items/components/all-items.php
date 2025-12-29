<table id="search-table">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    Name Item
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Unit Item
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Sold Item This Month
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Action
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 

                $all_items_sql = $connect->prepare("SELECT * FROM items WHERE status_item = 1");

                $all_items_sql->execute();

                while ($item = $all_items_sql->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                        <tr>
                            <td class="font-medium text-heading whitespace-nowrap"><?php echo htmlspecialchars($item['name_item'])?></td>
                            <td><?php echo htmlspecialchars($item['unit_item'])?></td>

                            <?php 
                                
                                $item_sold_month = 0;

                            ?>
                            <td><?php echo $item_sold_month;?></td>
                            <td>
                                <button data-modal-target="edit-item-<?php echo $item['id_item']?>-modal" data-modal-toggle="edit-item-<?php echo $item['id_item']?>-modal" type="button" class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                                    <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button data-modal-target="delete-item-<?php echo $item['id_item']?>-modal" data-modal-toggle="delete-item-<?php echo $item['id_item']?>-modal" type="button" class="inline-flex items-center text-white bg-red-600 hover:bg-red-600 box-border border border-transparent focus:ring-4 focus:ring-red-400 shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
                                    <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                    </svg>
                                    Delete
                                </button>
                            </td>

                            <div id="edit-item-<?php echo $item['id_item']?>-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                            <h3 class="text-lg font-medium text-heading">
                                                Edit Item
                                            </h3>
                                            <button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="crud-modal">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <form action="<?php echo $location_index?>/backend/item.php" method="post">
                                            <input type="hidden" name="id_item" value="<?php echo $item['id_item']?>">
                                            <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                                                <div class="col-span-2">
                                                    <label for="name_item" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                                                    <input type="text" name="name_item" id="name_item" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Type item name" value="<?php echo htmlspecialchars($item['name_item'])?>" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="unit_item" class="block mb-2.5 text-sm font-medium text-heading">Unit</label>
                                                    <input type="text" name="unit_item" id="unit_item" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Type item name" value="<?php echo htmlspecialchars($item['unit_item'])?>" required="">
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                                <button name="edit_item" type="submit" class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                    <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                                                    </svg>

                                                    Edit item
                                                </button>
                                                <button data-modal-hide="crud-modal" type="button" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 

                            <div id="delete-item-<?php echo $item['id_item']?>-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                                            <button type="button" class="absolute top-3 end-2.5 text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-fg-disabled w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                            <h3 class="mb-6 text-body">Are you sure you want to delete <?php echo htmlspecialchars($item['name_item'])?> from the inventory?</h3>
                                            <div class="flex items-center space-x-4 justify-center">
                                                <form action="<?php echo $location_index?>/backend/" method="post">
                                                    <input type="hidden" name="id_item" value="<?php echo $item['id_item']?>">
                                                    <button name="delete_item" data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-danger-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                    Yes, I'm sure
                                                    </button>
                                                </form>
                                                <button data-modal-hide="popup-modal" type="button" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">No, cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php

                }

            ?>
        
    </tbody>
</table>

<center>
    <button type="button" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">New Item</button>
</center>


<script>

    if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#search-table", {
            searchable: true,
            sortable: false
        });
    }

</script>