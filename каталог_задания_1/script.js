window.addEventListener("DOMContentLoaded", function () {
    let t = document.body;
    const colors = ['seagreen','slateblue','sienna','salmon','steelblue'];
    let r = Math.floor(Math.random() * 5);
    t.style.backgroundColor = colors[r];
});