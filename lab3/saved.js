window.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal");
    window.history.pushState("MODAL", "modal", "#saved");
    history.back();
    modal.addEventListener("show.bs.modal", event => {
        this.window.history.go(1);
    });
    var f = true;
    modal.addEventListener("hide.bs.modal", event => {
        if (f){
            f = false;
            window.history.back();
            f = true;
        }
    });
    window.addEventListener("popstate", event => {
        if (f){
            f = false;
            if (location.hash == "#saved"){
                $("#modal").modal("show");
            }
            else {
                $("#modal").modal("hide");
            }
            f = true;
        }
    });
});