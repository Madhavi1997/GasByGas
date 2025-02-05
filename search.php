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
    <?php include 'assets/components/header.php'; ?>

    <div class="container" style="padding-top: 120px">
        <h2 class="text-center fw-bold">Search your nearest Gas Outlet</h2>
        <p class="text-center">Select Outlet by District</p>

        <div class="row justify-content-center mb-4">
            <div class="col-md-4">
                <label for="district" class="form-label">Select District</label>
                <select id="district" class="form-select">
                    <option selected>Anuradhapura</option>
                    <option>Ampara</option>
                    <option>Badulla</option>
                    <option>Batticaloa</option>
                    <option>Colombo</option>
                    <option>Galle</option>
                    <option>Gampaha</option>
                    <option>Hambantota</option>
                    <option>Jaffna</option>
                    <option>Kaluthara</option>
                    <option>Kandy</option>
                    <option>Kegalle</option>
                    <option>Kilinochchi</option>
                    <option>Kurunegala</option>
                    <option>Mannar</option>
                    <option>Matale</option>
                    <option>Matara</option>
                    <option>Monaragala</option>
                    <option>Mullativu</option>
                    <option>Nuwara Eliya</option>
                    <option>Polonnaruwa</option>
                    <option>Puttalam</option>
                    <option>Rathnapura</option>
                    <option>Trincomalee</option>
                    <option>Vavuniya</option>

                </select>
            </div>
            <div class="col-md-4">
                <label for="cylinder" class="form-label">Cylinder Brand</label>
                <select id="cylinder" class="form-select">
                    <option selected>Laughs</option>
                    <option>Litro</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Find Outlets</button>
            </div>
        </div>

        <h4 class="text-center fw-bold">Nearest Outlets</h4>

        <div class="row">
            <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5 class="fw-bold">Fuel Station <?= $i ?> - Anuradhapura</h5>
                    <p>Gas Cylinder - 2.5kg <span class="text-success">&#9679; In Stock</span></p>
                    <p>Gas Cylinder - 5kg <span class="text-success">&#9679; In Stock</span></p>
                    <p>Gas Cylinder - 12kg <span class="text-danger">&#9679; Out of Stock</span></p>
                    <p>Location: Thambuttegama Road, Puttalam - Anuradhapura - Trincomalee Hwy</p>
                    <button class="btn btn-primary request-gas-btn" data-bs-toggle="modal"
                        data-bs-target="#requestGasModal" data-outlet="Outlet <?= $i ?>">Request Gas</button>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Request Gas Modal -->
    <div class="modal fade" id="requestGasModal" tabindex="-1" aria-labelledby="requestGasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestGasModalLabel">Request Gas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="selected-outlet" class="fw-bold mb-3"></p>
                    <div class="mb-3">
                        <label class="form-label">Cylinder Type</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cylinderType" id="newGas"
                                value="New gas cylinder" checked>
                            <label class="form-check-label" for="newGas">New gas cylinder</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cylinderType" id="refillGas"
                                value="Refill gas cylinder">
                            <label class="form-check-label" for="refillGas">Refill gas cylinder</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Enter Quantity (Max: 3)</label>
                        <input type="number" id="quantity" class="form-control" min="1" max="3" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"><a href="order-review.php"
                            style="color: white;">Procced To Payment</a></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const requestGasButtons = document.querySelectorAll('.request-gas-btn');
        const outletLabel = document.getElementById('selected-outlet');

        requestGasButtons.forEach(button => {
            button.addEventListener('click', () => {
                const outlet = button.getAttribute('data-outlet');
                outletLabel.textContent = `Selected Outlet: ${outlet}`;
            });
        });
    });
    </script>
</body>

</html>