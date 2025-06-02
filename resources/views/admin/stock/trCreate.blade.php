<tr>
    <td>
        <select class="form-control ubahSelect select2-item item_id" name="item[{{ $no }}][item_id]" onchange="cekStokAkhir(this)">
            <option value="">-- Pilih Item --</option>
            @foreach ($item as $row)
                <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <select class="form-control ubahSelect select2-warehouse warehouse_id" name="item[{{ $no }}][warehouse_id]" onchange="cekStokAkhir(this)">
            <option value="">-- Pilih Lokasi Item --</option>
            @foreach ($warehouse as $row)
                <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control desimal initial_stock" name="item[{{ $no }}][initial_stock]" readonly value="0" autocomplete="off">
    </td>
    <td>
        <input type="text" class="form-control desimal final_stock" name="item[{{ $no }}][final_stock]" placeholder="Ketikkan Stock Akhir" autocomplete="off">
    </td>
    <td>
        <button type="button" class="btn btn-danger btnHapus" onclick="deleteItem(this)">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>