<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Order List</h2>
    <table id="order-histories-table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>devices_uuid</th>
            <th>product_id</th>
            <th>product_name</th>
            <th>receipt_token</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        <!-- DataTables will populate the table body dynamically -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#order-histories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('listOrderHistory') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'devices_uuid', name: 'devices_uuid'},
                {data: 'product_id', name: 'product_id'},
                {data: 'product.name', name: 'product.name'},
                {data: 'receipt_token', name: 'receipt_token'},
                {data: 'created_at', name: 'created_at'},
            ],
            order: [[3, 'desc']], // Default order by Created At
        });
    });
</script>
</body>
</html>
