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
                <h1 class="h3 mb-2 text-gray-800">Tambahkan Customer</h1>
                <form class="customer" action="valas" method="post">
                    @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control"
                                    id="nama_customer" name="nama_customer" placeholder="Nama Customer">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"
                                id="alamat_customer" name="alamat_customer" placeholder="Alamat Customer">
                            </div>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-user btn-block">
                            Tambahkan Customer
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
                                            <th>Alamat</th>
                                            <th>Membership</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $c)
                                            <tr>
                                                <td>{{ $c->nama }}</td>
                                                <td>{{ $c->alamat }}</td>
                                                <td>{{ $c->membership->nama }}</td>
                                                <td align="right">
                                                    <input type="hidden" value="{{ $c->id }}">
                                                    <button id="edit-btn" class="btn btn-success ">
                                                        Edit
                                                    </button>
                                                    <button id="delete-btn" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </td>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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
        let state = 'ADD';
        let currentId = '';
        //Edit
        document.querySelector('.table').addEventListener('click', async(e) => {
            const target = e.target;
            const csrfToken= document.querySelector("input[name='_token']").value;
            /* THIS SECTION FOR EDIT BRUH */
            if(target.id === 'edit-btn') { 
                const customerId = parseInt(e.target.parentElement.children[0].value)
                try {
                    const customerRes = await fetch(`customer/${customerId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if(customerRes.status !== 200) {
                        const err = await customerRes.json();
                        throw new Error(err.message);
                    };
                    state = 'EDIT';
                    currentId = customerId;

                    const customer = await customerRes.json();
                    document.querySelector('#nama_customer').value = customer.nama;
                    document.querySelector('#alamat_customer').value = customer.alamat;

                    if(!document.querySelector('#back-btn')) {
                        document.querySelector('#submit-btn').textContent = 'UPDATE DATA';
                        const parentEl = document.querySelector('#submit-btn').parentElement;
                        const btnBack = document.createElement('button');
                        btnBack.id = 'back-btn';
                        btnBack.className = 'btn btn-danger btn-user btn-block';
                        btnBack.textContent = 'Batal Edit';
                        btnBack.onclick = (e) => {
                            state = 'ADD';
                            currentId = '';
                            document.querySelector('#submit-btn').textContent = 'Tambahkan Customer';
                            btnBack.remove();
                            document.querySelector('#nama_customer').value = '';
                            document.querySelector('#alamat_customer').value = '';
                        };
                            parentEl.appendChild(btnBack);
                        };
                } catch(err){
                    window.alert(err.message);
                };
            };
            /*THIS SECTION FOR DELETE BRUH */
            if(target.id === 'delete-btn') {
                const customerId = parseInt(e.target.parentElement.children[0].value);
                if(window.confirm('Apakah anda yakin')){
                    try {
                        const deleteRes = await fetch(`customer/${customerId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        if(deleteRes.status !== 204) {
                            const err = await deleteRes.json();
                            throw new Error(err.message);
                        };

                        window.location.reload();
                    } catch(err){
                        window.alert(err.message);
                    };
                }; 
            };
        });

        //Submit
        document.querySelector('.customer').addEventListener('submit',  async(e) => {
            e.preventDefault();
            try {
                //Fetch Value
                const namaCustomer = document.querySelector('#nama_customer').value;
                const alamatCustomer = document.querySelector('#alamat_customer').value;
                const csrfToken= document.querySelector("input[name='_token']").value;

                if(!namaCustomer || !alamatCustomer) {
                    throw new Error('Silahkan isi keseluruhan Form');
                };
                
                const res = await fetch(state === 'ADD' ? 'customer' : `customer/${currentId}`, {
                    method: state === 'ADD' ? 'POST' : 'PUT',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                    body: JSON.stringify({
                        nama: namaCustomer,
                        alamat: alamatCustomer
                    })
                });

                if(res.status !== 201 && res.status !== 200) {
                    const err = await res.json();
                    throw new Error(err.message);
                };

                window.location.reload();
            } catch(err) {
                window.alert(err.message);
            };
        });
    </script>
</body>
</html>