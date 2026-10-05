const form = document.getElementById('calculator-form');
const output = document.getElementById('result');
const button = form.querySelector('button');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    button.disabled = true;
    button.textContent = 'Calculating…';
    output.hidden = true;
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
        });
        const data = await response.json();
        output.classList.toggle('error', !response.ok);
        output.textContent = response.ok ? `Result: ${data.result}` : data.error;
    } catch {
        output.classList.add('error');
        output.textContent = 'Could not calculate. Please try again.';
    } finally {
        output.hidden = false;
        button.disabled = false;
        button.textContent = 'Calculate';
    }
});
