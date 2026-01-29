import "./bootstrap";
import $ from "jquery";
import DataTable from "datatables.net-dt";
import "datatables.net-dt/css/dataTables.dataTables.css"; // Jangan lupa CSS-nya!

// Tempelkan jQuery ke window supaya bisa diakses global (opsional tapi sering butuh)
window.$ = window.jQuery = $;

// Inisialisasi
$(document).ready(function () {
    new DataTable("#myTable");
});
