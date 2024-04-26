@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Atur Ketersediaan {{$data->nama_mobil}}</h1>
    <h6>Tentukan tanggal spesifik dimana {{$data->nama_mobil}} tidak tersedia untuk pemesanan karena telah dipesan oleh pihak lain</h6>
    <form action="" method="post">
        @csrf
        <div class="card mt-3 mb-5 p-3">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$data2->isEmpty())
                            @foreach ($data2 as $item)
                                <tr>
                                    <td><input type="date" class="form-control" id="mulai{{$loop->iteration}}" name="mulai{{$loop->iteration}}" value="{{$item->tanggal_mulai}}"></td>
                                    <td><input type="date" class="form-control" id="selesai{{$loop->iteration}}" name="selesai{{$loop->iteration}}" value="{{$item->tanggal_selesai}}"></td>
                                    <td><button type="button" class="btn btn-danger" onclick="close2({{$item->id_sedia}})"><i class="fa fa-trash" aria-hidden="true" style="cursor: pointer"></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary mb-3" onclick="addTimeInput2()">Add</button>
            </div>
        </div>
        <input type="hidden" id="" name="id" value="{{$data->id_mobil}}">
        <div class="d-flex justify-content-end">
            <a href="javascript:history.back()" class="btn btn-outline-danger me-3">Batal</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
<script>
    let counter2 = <?php echo count($data2); ?> + 1;
    function addTimeInput2() {
        const tbody = document.querySelector('.table tbody');
        
        const row = document.createElement('tr');

        const colMulai = document.createElement('td');
        colMulai.innerHTML = `
            <input type="date" class="form-control" id="mulai${counter2}" name="mulai${counter2}">
        `;

        const colSelesai = document.createElement('td');
        colSelesai.innerHTML = `
            <input type="date" class="form-control" id="selesai${counter2}" name="selesai${counter2}">
        `;

        const colAksi = document.createElement('td');
        colAksi.innerHTML = `
            <button class="btn btn-danger" onclick="hapusBaris(this)"><i class="fa fa-trash" aria-hidden="true" style="cursor: pointer"></i></button>
        `;

        row.appendChild(colMulai);
        row.appendChild(colSelesai);
        row.appendChild(colAksi);
        tbody.appendChild(row);

        counter2++;
    }

    function hapusBaris(button) {
        // Menghapus baris tabel yang sesuai dengan tombol yang ditekan
        const row = button.closest('tr');
        row.parentNode.removeChild(row);
    }

    function close2(id) {
        // const row = button.closest('tr');
        // row.parentNode.removeChild(row);
        
        var formData = {
            _token: '{{ csrf_token() }}', // Laravel CSRF token
            id: id,
            tujuan: '/admin/ketersediaan/hapus/' + id
        };

        // AJAX request to update the status
        $.ajax({
            url: '/admin/ketersediaan/hapus/' + id, // Replace with your backend endpoint
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                window.location.reload();
            },
            error: function (error) {
                console.error('Error updating notification status:', error);
            }
        });
    }
</script>
@endsection