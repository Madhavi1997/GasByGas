<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Selection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: rgba(0, 0, 0, 0.7);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .popup-card {
      max-width: 400px;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .btn-selection {
      min-width: 120px;
    }

    .btn-selection.active {
      background-color: #0d6efd;
      color: white;
    }
  </style>
</head>
<body>

  <div class="popup-card">
    <h5 class="fw-bold mb-3">Sign Up</h5>
    <p class="fw-semibold">I am a</p>

    <div class="d-flex justify-content-center gap-3 my-3">
      <button class="btn btn-outline-primary btn-selection" onclick="selectUser(this)">Domestic Customer</button>
      <button class="btn btn-outline-primary btn-selection" onclick="selectUser(this)">Industrial Customer</button>
      <button class="btn btn-outline-primary btn-selection" onclick="selectUser(this)">Outlet Manager</button>
    </div>

    <button class="btn btn-primary mt-4 w-100">Proceed to Signup</button>
  </div>

  <script>
    function selectUser(button) {
      document.querySelectorAll('.btn-selection').forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
