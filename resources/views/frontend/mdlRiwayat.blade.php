<div class="container">
    <p>Silahkan melakukan pembayaran sesuai dengan tagihan anda ketikan checkout pesanan, dengan mentransfer ke</p>
    <p class="account-details">No. Rekening: 5803045086<br>Dana: 085767113554</p>
    <p>Apabila anda telah melakukan pembayaran maka anda dapat mengupload bukti transfer tersebut pada halaman ini agar pesanan anda segera di proses jangan lupa untuk menyertakan nama pemesan.</p>
    <form action="formPembayaran" method="post" enctype="multipart/form-data" class="form">
        {{ csrf_field() }}

        <input type="file" name="bukti_transfer" required>
        <br>
        <br>
        <div class="mb-3 row">
            <label for="txtNama" class="col-sm-2 col-form-label">Nama Pemesanan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtNama" name="txtNama">
                <input type="hidden" class="form-control" id="id" name="id" value="{{$id}}">
            </div>
        </div>
        <!-- <button type="submit" class="upload">Upload</button>
            <button type="button" class="cancel" onclick="window.location.href='your_cancel_endpoint'">Cancel</button> -->
    </form>
</div>