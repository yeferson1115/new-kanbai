(function () {
  const cardInput = document.getElementById('card_number');
  const brandLabel = document.getElementById('card_brand');

  if (!cardInput || !brandLabel) {
    return;
  }

  const detectBrand = (cardNumber) => {
    if (/^4\d{12}(\d{3})?(\d{3})?$/.test(cardNumber)) return 'Visa';
    if (/^(5[1-5]\d{14}|2(2[2-9]\d{12}|[3-6]\d{13}|7[01]\d{12}|720\d{12}))$/.test(cardNumber)) return 'Mastercard';
    if (/^3[47]\d{13}$/.test(cardNumber)) return 'Amex';
    return 'Desconocida';
  };

  cardInput.addEventListener('input', function () {
    const raw = this.value.replace(/\D/g, '').slice(0, 19);
    this.value = raw.replace(/(.{4})/g, '$1 ').trim();
    brandLabel.textContent = detectBrand(raw);
  });
})();
