<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
  <!-- Header -->
  <?php include 'assets/components/header.php'; ?>

  <div class="container" style="padding-top: 120px;">
    <div class="card shadow-lg mx-auto" style="max-width: 600px; padding: 20px;">
      <h2 class="text-center mb-4">How would you like to pay?</h2>

      <div class="card-payment">
        <form>
          <div class="mb-4">
            <h5>Select Payment Method</h5>

            <div class="custom-radio">
              <input type="radio" id="creditCard" name="paymentMethod" value="credit" class="form-check-input" checked>
              <label class="form-check-label" for="creditCard">Pay with Credit Card</label>

              <div class="card-info mt-3">
                <div class="row">
                  <div class="col-12">
                    <input type="text" class="form-control" placeholder="Name on card" value="Amara Dissanayake" required>
                  </div>
                  <div class="col-12 mt-2">
                    <input type="text" class="form-control" placeholder="Card number" value="1234 1234 1234 1234" required>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-6">
                    <input type="text" class="form-control" placeholder="Expiry (MM/YYYY)" value="06/2025" required>
                  </div>
                  <div class="col-6">
                    <input type="text" class="form-control" placeholder="CVV" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="custom-radio">
              <input type="radio" id="cashDoorstep" name="paymentMethod" value="cashDoorstep" class="form-check-input">
              <label class="form-check-label" for="cashDoorstep">Cash Payment (Pay at your doorstep)</label>
            </div>

            <div class="custom-radio">
              <input type="radio" id="cashOutlet" name="paymentMethod" value="cashOutlet" class="form-check-input">
              <label class="form-check-label" for="cashOutlet">Cash Payment (Pay at the outlet)</label>
            </div>
          </div>

          <p class="payment-security-text">
            <i class="bi bi-shield-lock-fill"></i> We protect your payment information using encryption to provide bank-level security.
          </p>

          <div class="nav-buttons mt-4 d-flex justify-content-between">
            <button type="button" class="btn btn-secondary">Back</button>
            <button type="submit" class="btn btn-primary">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'assets/components/footer.php'; ?>
</body>

</html>