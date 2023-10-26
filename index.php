<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_factory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class Supplier {
    public $id;
    public $name;
    public $contact;
    public $address;

    public function __construct($id, $name, $contact, $address) {
        $this->id = $id;
        $this->name = $name;
        $this->contact = $contact;
        $this->address = $address;
    }
}

class Customer {
    public $id;
    public $name;
    public $contact;
    public $address;

    public function __construct($id, $name, $contact, $address) {
        $this->id = $id;
        $this->name = $name;
        $this->contact = $contact;
        $this->address = $address;
    }
}

function createSupplier($id, $name, $contact, $address) {
    return new Supplier($id, $name, $contact, $address);
}

function createCustomer($id, $name, $contact, $address) {
    return new Customer($id, $name, $contact, $address);
}

$suppliers = array();
$customers = array();

$sql = "SELECT * FROM supplier";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $supplier = createSupplier($row["id"], $row["name"], $row["contact"], $row["address"]);
        $suppliers[] = $supplier;
    }
}

$sql = "SELECT * FROM customer";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customer = createCustomer($row["id"], $row["name"], $row["contact"], $row["address"]);
        $customers[] = $customer;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Factory</title>
</head>
<body>
    <div class="button-container">
        <button id="openSupplierModal">Supplier</button>
        <button id="openCustomerModal">Customer</button>
    </div>

    <div id="supplierModal" class="modal">
        <div class="modal-content">
            <h2>Supplier Information</h2>
            <table class="supplier-table">
                <tr>
                    <td>Supplier ID:</td>
                    <td>Name:</td>
                    <td>Contact:</td>
                    <td>Address:</td>
                </tr>
                <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?php echo $supplier->id; ?></td>
                    <td><?php echo $supplier->name; ?></td>
                    <td><?php echo $supplier->contact; ?></td>
                    <td><?php echo $supplier->address; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <span class="close" id="closeSupplierModal">Close</span>
        </div>
    </div>

    <div id="customerModal" class="modal">
        <div class="modal-content">
            <h2>Customer Information</h2>
            <table class="customer-table">
                <tr>
                    <td>Customer ID:</td>
                    <td>Name:</td>
                    <td>Contact:</td>
                    <td>Address:</td>
                </tr>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo $customer->id; ?></td>
                    <td><?php echo $customer->name; ?></td>
                    <td><?php echo $customer->contact; ?></td>
                    <td><?php echo $customer->address; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <span class="close" id="closeCustomerModal">Close</span>
        </div>
    </div>

    <script>
        var supplierModal = document.getElementById("supplierModal");
        var customerModal = document.getElementById("customerModal");
        var buttonContainer = document.querySelector(".button-container");

        function toggleModal(modal) {
            modal.style.display = modal.style.display === "block" ? "none" : "block";
        }

        buttonContainer.addEventListener("click", function (event) {
            if (event.target.id === "openSupplierModal") {
                toggleModal(supplierModal);
            } else if (event.target.id === "openCustomerModal") {
                toggleModal(customerModal);
            }
        });

        supplierModal.querySelector(".close").addEventListener("click", function () {
            toggleModal(supplierModal);
        });

        customerModal.querySelector(".close").addEventListener("click", function () {
            toggleModal(customerModal);
        });
    </script>
</body>
</html>