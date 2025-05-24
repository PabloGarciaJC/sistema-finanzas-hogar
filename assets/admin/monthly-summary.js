document.addEventListener('DOMContentLoaded', function () {
  const incomeInput = document.querySelector('input[name="MonthlySummary[totalIncome]"]');
  const serviceInput = document.querySelector('input[name="MonthlySummary[debt_total]"]');
  const creditOneInput = document.querySelector('input[name="MonthlySummary[bankDebtMemberOne]"]');
  const creditTwoInput = document.querySelector('input[name="MonthlySummary[bankDebtMemberTwo]"]');
  const goalInput = document.querySelector('input[name="MonthlySummary[goalTotal]"]');
  const remainingInput = document.querySelector('input[name="MonthlySummary[remainingBalance]"]');

  function parseEuropeanFloat(value) {
    return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
  }

  function formatToEuropean(value) {
    return value.toFixed(2).replace('.', ',');
  }

  function recalculate() {
    const income = parseEuropeanFloat(incomeInput?.value || "0");
    const service = parseEuropeanFloat(serviceInput?.value || "0"); // se sobrescribirá abajo
    const creditOne = parseEuropeanFloat(creditOneInput?.value || "0");
    const creditTwo = parseEuropeanFloat(creditTwoInput?.value || "0");
    const goal = parseEuropeanFloat(goalInput?.value || "0");

    const newDebtTotal = creditOne + creditTwo + goal;

    // Actualizar deuda total
    if (serviceInput) {
      serviceInput.value = formatToEuropean(newDebtTotal);
    }

    // Calcular saldo restante con el nuevo valor
    const remaining = income - newDebtTotal;

    if (remainingInput) {
      remainingInput.value = formatToEuropean(remaining);
    }
  }

  // Listeners
  [incomeInput, creditOneInput, creditTwoInput, goalInput].forEach((input) => {
    input?.addEventListener("input", recalculate);
  });

  // Inicial
  recalculate();
});
