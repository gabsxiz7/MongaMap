document.addEventListener('DOMContentLoaded', function () {
  const inputSenha = document.getElementById('nova_senha');
  const ruleLength  = document.getElementById('ruleLength');
  const ruleLower   = document.getElementById('ruleLower');
  const ruleUpper   = document.getElementById('ruleUpper');
  const ruleNumber  = document.getElementById('ruleNumber');
  const ruleSpecial = document.getElementById('ruleSpecial');
  const form = document.getElementById('formRedefinir');

  // Função para testar cada regra usando regex
  function validarRegras(senha) {
    const regras = {
      length: senha.length >= 8,
      lower:  /[a-z]/.test(senha),
      upper:  /[A-Z]/.test(senha),
      number: /\d/.test(senha),
      special: /[@$!%*#?&]/.test(senha)
    };
    return regras;
  }

  // Ao digitar no campo, checa as regras
  inputSenha.addEventListener('input', function () {
    const valor = inputSenha.value;
    const v = validarRegras(valor);

    ruleLength.classList.toggle('valid',  v.length);
    ruleLower.classList.toggle('valid',   v.lower);
    ruleUpper.classList.toggle('valid',   v.upper);
    ruleNumber.classList.toggle('valid',  v.number);
    ruleSpecial.classList.toggle('valid', v.special);
  });

  // Ao submeter o form, impede se alguma regra não estiver atendida
  form.addEventListener('submit', function (evt) {
    const s = inputSenha.value;
    const r = validarRegras(s);
    // Se algo for false, impede o envio e mostra alert
    if (!r.length || !r.lower || !r.upper || !r.number || !r.special) {
      evt.preventDefault();
      alert('Sua senha não atende a todos os critérios. Verifique as regras antes de continuar.');
      inputSenha.focus();
    }
  });
});

