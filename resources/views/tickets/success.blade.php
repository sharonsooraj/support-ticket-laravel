<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ticket Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Your ticket has been submitted successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
    </script>
</body>

</html>
