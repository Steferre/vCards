// questo file serve per aggiungere il messaggio di conferma di un'azione
const findBtns = document.querySelectorAll('#confirmChoise');

console.log(findBtns);
// findBtns è un array

findBtns.forEach(btn => disableEnableRow(btn));


function disableEnableRow(obj) {
    if (obj !== null) {
        obj.addEventListener('click', function(event) {
            const userChoise = confirm('vuoi continuare?');
            
            if(!userChoise) {
                console.log(userChoise);
                event.preventDefault();
            } else {
                console.log('comando eseguito!!!');
            }
        })
    }
}