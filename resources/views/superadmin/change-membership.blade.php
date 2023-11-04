<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CRUD</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    @include('../include/navigation')
        <!-- Begin Page Content -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="content">
                @include('../include/topbar')
                <div class="container-fluid">
                <h1 class="h3 mb-2 text-gray-800">Edit Customer Membership</h1>
                <form class="customer" action="valas" method="post">
                    @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select name="customer" id="customer" class="form-control">
                                        @foreach($customers as $c) 
                                            <option value='{{ $c->id }}'>{{ $c->nama }} </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="membership" id="membership" class="form-control">
                                    @foreach($memberships as $m) 
                                        <option value='{{ $m->id }}'>{{ $m->nama }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-user btn-block">
                            Edit Customer
                        </button>
                    </form>
                    <br>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Customer</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Membership</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $c)
                                            <tr>
                                                <td>{{ $c->nama }}</td>
                                                <td>{{ $c->membership->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    @include('../include/logout')

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script defer>
        //Submit
        document.querySelector('.customer').addEventListener('submit',  async(e) => {
            e.preventDefault();
            try {
                //Fetch Value
                const customerId = document.querySelector('#customer').value;
                const membershipId = document.querySelector('#membership').value;
                const csrfToken= document.querySelector("input[name='_token']").value;

                if(!customerId || !membershipId) {
                    throw new Error('Silahkan isi keseluruhan Form');
                };
                
                const res = await fetch('change-membership', {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                    body: JSON.stringify({
                        customer_id: parseInt(customerId),
                        membership_id: parseInt(membershipId)
                    })
                });

                if(res.status !== 201 && res.status !== 200) {
                    const err = await res.json();
                    throw new Error(err.message);
                };

                if(window.confirm("Membership berhasil diganti")) return window.location.reload();
            } catch(err) {
                window.alert(err.message);
            };
        });
    </script>
</body>
</html>