<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CRUD - Transaksi</title>

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
                <h1 class="h3 mb-2 text-gray-800">Tambahkan Transaksi</h1>
                <form class="transaksi" action="valas" method="post">
                    @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="jual" selected >JUAL</option>
                                    <option value="beli">BELI</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="nomor_transaksi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <select name="customer" id="customer" class="form-control">
                                    @foreach($customer as $c) 
                                        <option value='{{ $c->id }}'>{{ $c->nama }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="valas" id="valas" class="form-control">
                                    <option>
                                        @foreach($valas as $v) 
                                            <option value='{{ $v->id }}'>{{ $v->nama_valas }} | Jual : {{ $v->nilai_jual }} |Beli : {{ $v->nilai_beli}}  </option>
                                        @endforeach
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" min=1
                                id="qty" name="qty" placeholder="Qty">
                            </div>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-user btn-block">
                            Tambahkan Transaksi
                        </button>
                    </form>
                    <br>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Membership</h1>
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
                                            <th>Nomor</th>
                                            <th>Nama Customer</th>
                                            <th>Diskon</th>
                                            <th>Valas</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Total Tagihan(Rp)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $d->nomor }}</td>
                                                <td>{{ $d->customer->nama }}</td>
                                                <td>{{ $d->diskon}}</td>
                                                <td>{{ $d->detail->nama_valas }}</td>
                                                <td>{{ $d->detail->rate }}</td>
                                                <td>{{ $d->detail->qty }}</td>
                                                <td>{{ $d->detail->rate * $d->detail->qty - $d->diskon}}</td>
                                                <td align="right">
                                                    <input type="hidden" value="{{ $d->id }}">
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

        //Helper
        const selectSelected = (elementSelector, targetValue) => {
            Array.from(document.querySelector(elementSelector).children).forEach(c => {
                if(c.value === targetValue.toString()) {
                    c.selected = true;
                };
            });
        };
        //Edit
        document.querySelector('.table').addEventListener('click', async(e) => {
            const target = e.target;
            const csrfToken= document.querySelector("input[name='_token']").value;
            /* THIS SECTION FOR EDIT BRUH */
            if(target.id === 'edit-btn') { 
                const actionId = parseInt(e.target.parentElement.children[0].value)
                try {
                    const res = await fetch(`transaksi/${actionId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if(res.status !== 200) {
                        const err = await res.json();
                        throw new Error(err.message);
                    };
                    state = 'EDIT';
                    currentId = actionId;

                    const data = await res.json();
                    const splitNomor = data.nomor.split('-');
                    //select
                    selectSelected('#jenis', splitNomor[0].toLowerCase());
                    //text
                    document.querySelector('#nomor_transaksi').value = parseInt(splitNomor[1]);
                    //select
                    selectSelected('#customer', data.customer_id);
                    //select->text
                    const prevOption = document.querySelector('#valas').innerHTML;
                    const opt = document.createElement('option');
                    opt.value = -1;
                    opt.textContent = `${data.detail.nama_valas} | Rate : ${data.detail.rate}`;
                    document.querySelector('#valas').innerHTML = '';
                    document.querySelector('#valas').appendChild(opt);
                    //number
                    document.querySelector('#qty').value = data.detail.qty;

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
                            document.querySelector('#submit-btn').textContent = 'Tambahkan Transaksi';
                            btnBack.remove();
                            //select
                            document.querySelectorAll('#jenis option')[0].selected = true;
                            //text
                            document.querySelector('#nomor_transaksi').value = ''
                            //select
                            document.querySelector('#customer option:checked').selected = false;
                            //select->text
                            document.querySelector('#valas').innerHTML = prevOption;
                            //number
                            document.querySelector('#qty').value = 1;
                        };
                            parentEl.appendChild(btnBack);
                        };
                } catch(err){
                    window.alert(err.message);
                };
            };
            /*THIS SECTION FOR DELETE BRUH */
            if(target.id === 'delete-btn') {
                const actionId = parseInt(e.target.parentElement.children[0].value);
                if(window.confirm('Apakah anda yakin')){
                    try {
                        const deleteRes = await fetch(`transaksi/${actionId}`, {
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
        document.querySelector('.transaksi').addEventListener('submit',  async(e) => {
            e.preventDefault();
            try {
                //Fetch Value
                const jenis = document.querySelector('#jenis').value;
                const nomorTransaksi = document.querySelector('#nomor_transaksi').value;
                const nomor = jenis + '-' + nomorTransaksi;
                const customer_id = document.querySelector('#customer').value;
                const valas_id = document.querySelector('#valas').value;
                const qty = document.querySelector('#qty').value;
                const csrfToken= document.querySelector("input[name='_token']").value;

                if(!jenis || !nomorTransaksi || !customer_id || !valas_id || !qty) {
                    throw new Error('Silahkan isi keseluruhan Form');
                };
                
                const res = await fetch(state === 'ADD' ? 'transaksi' : `transaksi/${currentId}`, {
                    method: state === 'ADD' ? 'POST' : 'PUT',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                    body: JSON.stringify({
                        nomor,
                        customer_id,
                        valas_id,
                        qty
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