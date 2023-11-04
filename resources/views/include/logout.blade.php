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
            <div class="modal-body">Anda yakin untuk logout?</div>
            <div class="modal-footer">
                @csrf
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="logout-btn">Logout</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('logout-btn').addEventListener('click', async (e) => {
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const res = await fetch('logout', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken}
        });

        if(res.status === 204) {
            window.location = '/';
        };
    });
</script>