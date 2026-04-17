import "./bootstrap";
import $ from "jquery";
import DataTable from "datatables.net-dt";
import "datatables.net-dt/css/dataTables.dataTables.css";
import { initAllAnimations } from "./animations-index.js";

// Tempelkan jQuery ke window supaya bisa diakses global (opsional tapi sering butuh)
window.$ = window.jQuery = $;

// Initialize animations
$(document).ready(function () {
    new DataTable("#myTable");

    // Initialize all GSAP animations
    initAllAnimations();

    // Reinitialize animations on Livewire navigation
    document.addEventListener("livewire:navigated", () => {
        setTimeout(initAllAnimations, 100);
    });
});
