
const calculators = document.querySelectorAll('.calculator-block');
console.log(calculators);

calculators.forEach(block => {
  const form = block.querySelector('.calc-form');
  const resultDiv = block.querySelector('.calc-result');
  const resetBtn = block.querySelector('.calc-reset');
  const useResultBtn = block.querySelector('.calc-use-result');

  if (form) {
    const input1 = form.querySelector('input[name="num1"]');
    const input2 = form.querySelector('input[name="num2"]');
    form.addEventListener('submit', function (e) {
      e.preventDefault();

    const formData = new FormData(form);
    formData.append('action', 'calculate');
    formData.append('nonce', CalculatorAjax.nonce);
    

      fetch(CalculatorAjax.ajax_url, {
          method: 'POST',
          body: formData,
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              resultDiv.innerText = 'Result: ' + data.data.result;
              resultDiv.style.display = 'block';
              resetBtn.style.display = 'inline-block';
              if (!isNaN(data.data.result)) {
                useResultBtn.style.display = 'inline-block';
              } else {
                useResultBtn.style.display = 'none'; 
              }
          } else {
              resultDiv.innerText = 'Calculation error';
              resultDiv.style.display = 'block';
          }
      })
      .catch(() => {
          resultDiv.innerText = 'Request error';
          resultDiv.style.display = 'block';
      });
    });

    resetBtn.addEventListener('click', function () {
      resultDiv.style.display = 'none';
      resetBtn.style.display = 'none';
      form.style.display = 'block';
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

  };  

})



