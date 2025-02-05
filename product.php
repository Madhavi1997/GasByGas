<?php
session_start();
require("assets/components/db_connection.php");

// Fetch data from tbl_product
$sql = "SELECT * FROM tbl_product";
$result = $mysqli->query($sql);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Nearest Outlets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- Header -->
    <?php include 'assets/components/header_admin.php'; ?>
    <section class="product">
        <div class="container-fluid d-flex align-items-center" style="padding-top: 150px; padding-bottom: 200px;">
            <div class="row w-100">
                <div class="col-md-12">
                    <h2 class="text-center fw-bold" style="color: var(--blue)">Products</h2>
                    <!-- Button to add new product -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addProductModal" style="margin-left: 85%; margin-top: -90px;">
                        Add New Product
                    </button>
                    <p class="text-center" style="color: var(--dark-grey); font-weight: bold;">Details related to
                        products
                    </p>
                </div>
            </div>
        </div>


        <!-- Display the results as cards -->
        <div class="row" style="margin-top: -100px; padding-left: 100px; padding-right: 100px;">
            <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h4 class="fw-bold"><?= htmlspecialchars($row['cylinder_brand']); ?></h4>
                    <p><strong>Cylinder Type:</strong> <?= htmlspecialchars($row['cylinder_type']); ?> kg</p>
                    <p><strong>Unit Price:</strong> Rs. <?= htmlspecialchars($row['unit_price']); ?></p>

                    <!-- Buttons for Edit and Delete (you can add functionality later) -->
                    <div class="d-flex justify-content-between">

                        <button class="btn-use edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                            data-product-id="<?= $row['product_id']; ?>"
                            data-cylinder-brand="<?= htmlspecialchars($row['cylinder_brand']); ?>"
                            data-cylinder-type="<?= htmlspecialchars($row['cylinder_type']); ?>"
                            data-unit-price="<?= htmlspecialchars($row['unit_price']); ?>">
                            Edit
                        </button>

                        <!-- Delete Button (Triggers Modal) -->
                        <button class="btn-use btn-danger delete-btn" data-bs-toggle="modal"
                            data-bs-target="#deleteProductModal" data-product_id="<?php echo $row['product_id']; ?>">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p class="text-center">No products found.</p>
            <?php endif; ?>
        </div>
    </section>


    <!-- Modal to Add New Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to Add Product -->
                    <form action="product_add.php" method="POST">
                        <div class="mb-3">
                            <label for="cylinderBrand" class="form-label" style="color: var(--dark-grey)">Cylinder
                                Brand</label>
                            <input type="text" class="form-control" id="cylinderBrand" name="cylinder_brand" required
                                style="border-color: var(--pink)">
                        </div>
                        <div class="mb-3">
                            <!-- <label for="cylinderType" class="form-label" style="color: var(--dark-grey)">Cylinder
                                Type</label>
                            <input type="text" class="form-control" id="cylinderType" name="cylinder_type"
                                style="border-color: var(--pink)" required> -->
                            <select name="cylinder_type" class="form-select" style="border-color: var(--pink);"
                                required>
                                <option value="" selected disabled>Select Cylinder Type</option>
                                <option value="2">2 kg</option>
                                <option value="5">5 kg</option>
                                <option value="12">12 kg</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unitPrice" class="form-label" style="color: var(--dark-grey)">Unit
                                Price</label>
                            <input type="number" class="form-control" id="unitPrice" name="unit_price" required
                                style="border-color: var(--pink)" min="0" step="0.01">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" action="product_edit.php" method="POST">
                        <div class="mb-3">
                            <label for="editCylinderBrand" class="form-label">Cylinder Brand</label>
                            <input type="text" class="form-control" id="editCylinderBrand" name="cylinder_brand"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editCylinderType" class="form-label">Cylinder Type</label>
                            <input type="number" class="form-control" id="editCylinderType" name="cylinder_type"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editUnitPrice" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="editUnitPrice" name="unit_price" required>
                        </div>
                        <input type="hidden" id="editProductId" name="product_id">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Populate the modal with data when Edit button is clicked
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const cylinderBrand = this.getAttribute('data-cylinder-brand');
            const cylinderType = this.getAttribute('data-cylinder-type');
            const unitPrice = this.getAttribute('data-unit-price');

            // Set the values in the modal
            document.getElementById('editProductId').value = productId;
            document.getElementById('editCylinderBrand').value = cylinderBrand;
            document.getElementById('editCylinderType').value = cylinderType;
            document.getElementById('editUnitPrice').value = unitPrice;
        });
    });
    </script>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: var(--dark-grey)">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="product_delete.php">
                        <input type="hidden" name="product_id" id="deleteProductId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const productId = this.getAttribute("data-product_id");
                document.getElementById("deleteProductId").value = productId;
            });
        });
    });
    </script>


    </div>

    </div>
    </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
    <?php include 'assets/components/scroll_top.php'; ?>

</body>

</html>

<?php
// Close the prepared statement
$stmt->close();
?>