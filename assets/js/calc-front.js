const calculators = document.querySelectorAll('.calculator-block');

calculators.forEach(block => {
  const form = block.querySelector('.calc-form');
  const resultDiv = block.querySelector('.calc-result');
  const resetBtn = block.querySelector('.calc-reset');
  const useResultBtn = block.querySelector('.calc-use-result');
  
  if (form) {
    const input1 = form.querySelector('input[name="num1"]');
    const input2 = form.querySelector('input[name="num2"]');
    const operation = form.querySelector('select[name="operation"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      fetch(CalculatorRest.rest_url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': CalculatorRest.nonce
        },
        body: JSON.stringify({
          num1: input1.value,
          num2: input2.value,
          operation: operation.value
        })
      })
      .then(async response => {
        const data = await response.json();
        return { ok: response.ok, data };
      })
      .then(({ ok, data }) => {
        if (!ok || data.error) {          
          resultDiv.innerText = data.error || 'Calculation error';
          useResultBtn.style.display = 'none';
        } else {
          resultDiv.innerText = 'Result: ' + data.result;
          if (!isNaN(data.result)) {
            useResultBtn.style.display = 'inline-block';
          }
        }

        resultDiv.style.display = 'block';
        resetBtn.style.display = 'inline-block';
      })
      .catch(() => {
        resultDiv.innerText = 'Request error';
        resultDiv.style.display = 'block';
        useResultBtn.style.display = 'none';
      });
    });

    resetBtn.addEventListener('click', function () {
      resultDiv.style.display = 'none';
      resetBtn.style.display = 'none';
      useResultBtn.style.display = 'none';
      form.reset();
      input1.focus();
    });

    useResultBtn.addEventListener('click', function () {
      input1.value = resultDiv.innerText.replace('Result: ', '');
      input2.value = '';
      input2.focus();
      resultDiv.style.display = 'none';
      useResultBtn.style.display = 'none';
    });
  }  
});
