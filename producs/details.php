<?php

    include "../app/BrandController.php";
	include "../app/ProductsController.php";

    $brandController = new BrandController();
	$productController = new ProductsController();

	$product_slug = $_GET['slug'];
	$producto = $productController->getProduct($product_slug);
    $brands = $brandController->getBrands();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../layouts/head.php" ?>
</head>
<body>
    <!-- navbar -->
    <?php include "../layouts/nadvar.php" ?>

    <!-- container -->
    <div class="container-fluid">

        <div class="row">
            <!-- sidebar -->
            <?php include "../layouts/sidebar.php" ?>

            <!-- contenido -->
            <div class="col-lg-10 col-sm-12 bg-white">

                <!--bead-->
                <div class="border-bottom">
                    <div class="row m-2">
                        <div class="col">
                            <h4>Productos</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xl-4 col-xxl-3 p-2">
                                <div class="card mb-1 ">
                                <img src="<?= $producto->cover ?>" class="card-img-top img-fluid" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><?php echo $producto->name ?></h5>
                                        <h6 class="card-subtitle text-center"><?= isset($producto->brand->name)?$producto->brand->name:'No Brand' ?></h6>
                                        <p class="card-text" style="text-align: justify;"><?php echo $producto->description ?></p>
                                        <div class="row">
                                            <a data-product='<?= json_encode($producto) ?>' href="#" class="btn btn-warning col-6" data-bs-toggle="modal" data-bs-target="#modalAñadirEditar" onclick="editProduct(this)">Editar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-4 col-sm-10 p-2">
							<h4>Etiquetas</h4>
							<ul>
								<?php foreach ($producto->tags as $tag): ?>
									<li><?= $tag->name ?></li>
								<?php endforeach ?>
							</ul>
							<br>
							<h4>Categorías</h4>
							<ul>
								<?php foreach ($producto->categories as $category): ?>
									<li><?= $category->name ?></li>
								<?php endforeach ?>
                            </ul>
						</div>
                </div>
            </div>
        </div>
    </div>
    <!-- modalAñadir -->
    <div class="modal fade" id="modalAñadirEditar" tabindex="-1" aria-labelledby="modalAñadirEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAñadirEditarLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data"  method="post" action="<?= BASE_PATH?>products">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Name</span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Product name" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">Slug</span>
                      <input id="slug" name="slug" type="text" class="form-control" placeholder="Product slug" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Description</span>
                        <input type="text" id="description" name="description" class="form-control" placeholder="Product description" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Features</span>
                        <input type="text" id="features" name="features" class="form-control" placeholder="Product features" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Brand_id</span>
                        <select class="form-control" id="brand_id" name="brand_id">
                            <?php if (isset($brands) && count($brands)): ?> 
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand->id ?>">
                                    <?= $brand->name ?>
                                </option>
                            <?php endforeach ?>
                            <?php endif ?>
                        </select> 
                    </div>
                    <div class="input-group mb-3">
					  <span class="input-group-text" id="basic-addon1">@</span>
					  <input name="cover" type="file" class="form-control" placeholder="Product features" aria-label="Username" aria-describedby="basic-addon1">
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                <input type="hidden" id="oculto_input" name="action" value="create">
                <input type="hidden" id="id" name="id" value="create">
                <input type="hidden" value="<?= $_SESSION['global_token'] ?>" name="global_token"> 
            </form>
            </div>
        </div>
    </div>

    <?php include "../layouts/scripts.php" ?>
    
    <script>
        function editProduct(target){
            document.getElementById("oculto_input").value="update";
            let product = JSON.parse(target.getAttribute('data-product'));
            console.log(product.name);
            document.getElementById("name").value=product.name;
            document.getElementById("slug").value=product.slug;
            document.getElementById("description").value=product.description;
            document.getElementById("features").value=product.features;
            document.getElementById("brand_id").value=product.brand_id;
            document.getElementById("id").value=product.id;

        }
    </script>
</body>
</html>