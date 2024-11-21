<?php
function changeStatus($status)
{ //harus terisi, agar tidak bisa diisi bisa tambah = null 
    switch ($status) {
        case '1':
            $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
            break;
        default:
            $badge = "<span class='badge bg-warning'>Baru</span>";
            break;
    }
    return $badge;
}
