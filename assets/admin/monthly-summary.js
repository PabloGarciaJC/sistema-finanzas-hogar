
console.log('es una prueba');


  const incomeInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[totalIncome]"]');
  const serviceInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[debt_total]"]');
  const creditOneInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[bankDebtMemberOne]"]');
  const creditTwoInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[bankDebtMemberTwo]"]');
  const goalInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[goalTotal]"]');

  const remainingInput = document.querySelector<HTMLInputElement>('input[name="MonthlySummary[remainingBalance]"]');

  function recalculate() {
    const income = parseFloat(incomeInput?.value || "0");
    const service = parseFloat(serviceInput?.value || "0");
    const creditOne = parseFloat(creditOneInput?.value || "0");
    const creditTwo = parseFloat(creditTwoInput?.value || "0");
    const goal = parseFloat(goalInput?.value || "0");

    const remaining = income - service - creditOne - creditTwo - goal;
    if (remainingInput) {
      remainingInput.value = remaining.toFixed(2);
    }
  }

  [incomeInput, serviceInput, creditOneInput, creditTwoInput, goalInput].forEach((input) => {
    input?.addEventListener("input", recalculate);
  });

  // Llama una vez para inicializar
  recalculate();
