window.addEventListener('load', (event) => {
    const box = document.getElementById('timerBox');

    const updateBtn = document.getElementById('updateBtn');

    const tdanger = (document.getElementById('tdanger')) ? document.getElementById('tdanger') : null;

    box.addEventListener('click', function() {
        console.log('clicco sul messaggio');
    });

    function ghostBox() {
        box.style.display = "none";
    }
});